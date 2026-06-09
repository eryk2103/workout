import { Component, input, signal } from '@angular/core';
import { RouterLink } from '@angular/router';

interface SetLog {
  reps: number;
  kg: number;
}

interface ExerciseLog {
  name: string;
  sets: SetLog[];
}

@Component({
  selector: 'app-workout-log',
  imports: [RouterLink],
  templateUrl: './workout-log.html',
})
export class WorkoutLog {
  name = input.required<string>();

  protected readonly exercises = signal<ExerciseLog[]>([
    { name: 'Bench Press', sets: [{ reps: 10, kg: 60 }] },
    { name: 'Squat', sets: [{ reps: 8, kg: 80 }] },
    { name: 'Deadlift', sets: [{ reps: 5, kg: 100 }] },
  ]);

  protected addSet(exerciseIndex: number): void {
    this.exercises.update(list => {
      const next = [...list];
      const sets = next[exerciseIndex].sets;
      const last = sets[sets.length - 1];
      next[exerciseIndex] = { ...next[exerciseIndex], sets: [...sets, { ...last }] };
      return next;
    });
  }

  protected updateReps(exerciseIndex: number, setIndex: number, value: string): void {
    this.exercises.update(list => {
      const next = list.map((e, ei) => ei !== exerciseIndex ? e : {
        ...e,
        sets: e.sets.map((s, si) => si !== setIndex ? s : { ...s, reps: +value }),
      });
      return next;
    });
  }

  protected removeSet(exerciseIndex: number, setIndex: number): void {
    this.exercises.update(list =>
      list.map((e, ei) => ei !== exerciseIndex ? e : {
        ...e,
        sets: e.sets.filter((_, si) => si !== setIndex),
      })
    );
  }

  protected updateKg(exerciseIndex: number, setIndex: number, value: string): void {
    this.exercises.update(list => {
      const next = list.map((e, ei) => ei !== exerciseIndex ? e : {
        ...e,
        sets: e.sets.map((s, si) => si !== setIndex ? s : { ...s, kg: +value }),
      });
      return next;
    });
  }
}
