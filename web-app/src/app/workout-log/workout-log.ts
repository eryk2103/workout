import { Component, computed, effect, inject, input, signal } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { ExerciseSession } from '../exercises/exercise-session-model';
import { ExerciseSessionService } from '../exercises/exercise-session-service';
import { WorkoutSession } from '../workouts/workout-session-model';
import { WorkoutSessionService } from '../workouts/workout-session-service';

interface SetLog {
  id: number;
  reps: number;
  kg: number;
}

interface ExerciseLog {
  exerciseId: number;
  name: string;
  sets: SetLog[];
}

@Component({
  selector: 'app-workout-log',
  imports: [RouterLink],
  templateUrl: './workout-log.html',
})
export class WorkoutLog {
  id = input.required<string>();

  private readonly router = inject(Router);
  private readonly workoutSessionService = inject(WorkoutSessionService);
  private readonly exerciseSessionService = inject(ExerciseSessionService);

  protected readonly workoutSession = signal<WorkoutSession | null>(null);
  protected readonly exerciseSessions = signal<ExerciseSession[]>([]);

  protected readonly exercises = computed<ExerciseLog[]>(() => {
    const session = this.workoutSession();
    if (!session) {
      return [];
    }

    const setsByExercise = new Map<number, SetLog[]>();

    for (const exerciseSession of this.exerciseSessions()) {
      const list = setsByExercise.get(exerciseSession.exercise.id) ?? [];
      list.push({
        id: exerciseSession.id,
        reps: exerciseSession.reps ?? 0,
        kg: exerciseSession.weight ?? 0,
      });
      setsByExercise.set(exerciseSession.exercise.id, list);
    }

    return session.workout.exercises.map((exercise) => ({
      exerciseId: exercise.id,
      name: exercise.name,
      sets: setsByExercise.get(exercise.id) ?? [],
    }));
  });

  constructor() {
    effect(() => {
      const id = Number(this.id());

      this.workoutSessionService.getById(id).subscribe((session) => this.workoutSession.set(session));
      this.exerciseSessionService.getAll(id).subscribe((sessions) => this.exerciseSessions.set(sessions));
    });
  }

  protected addSet(exercise: ExerciseLog): void {
    const session = this.workoutSession();
    if (!session) {
      return;
    }

    const last = exercise.sets[exercise.sets.length - 1];

    this.exerciseSessionService
      .create({
        exerciseId: exercise.exerciseId,
        scheduledAt: new Date(session.scheduledAt),
        reps: last?.reps ?? 0,
        weight: last?.kg ?? 0,
        set: exercise.sets.length + 1,
        workoutSessionId: session.id,
      })
      .subscribe((created) => this.exerciseSessions.update((sessions) => [...sessions, created]));
  }

  protected updateReps(setId: number, value: string): void {
    this.updateSet(setId, { reps: +value });
  }

  protected updateKg(setId: number, value: string): void {
    this.updateSet(setId, { weight: +value });
  }

  protected removeSet(setId: number): void {
    this.exerciseSessionService
      .delete(setId)
      .subscribe(() => this.exerciseSessions.update((sessions) => sessions.filter((s) => s.id !== setId)));
  }

  private updateSet(setId: number, changes: { reps?: number; weight?: number }): void {
    const existing = this.exerciseSessions().find((s) => s.id === setId);
    if (!existing) {
      return;
    }

    this.exerciseSessionService
      .update(setId, {
        scheduledAt: new Date(existing.scheduledAt),
        reps: changes.reps ?? existing.reps ?? undefined,
        weight: changes.weight ?? existing.weight ?? undefined,
        set: existing.set ?? undefined,
        startAt: existing.startAt ? new Date(existing.startAt) : undefined,
        endAt: existing.endAt ? new Date(existing.endAt) : undefined,
      })
      .subscribe((updated) =>
        this.exerciseSessions.update((sessions) => sessions.map((s) => (s.id === setId ? updated : s))),
      );
  }

  protected finishWorkout(): void {
    const session = this.workoutSession();
    if (!session) {
      return;
    }

    const date = new Date(session.scheduledAt);
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');

    this.router.navigate(['/calendar', `${yyyy}-${mm}-${dd}`]);
  }
}
