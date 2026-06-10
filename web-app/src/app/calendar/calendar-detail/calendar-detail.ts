import { Component, computed, effect, inject, input, signal } from '@angular/core';
import { RouterLink } from '@angular/router';
import { Search } from '../../shared/search/search';
import { Workout } from '../../workouts/workout-model';
import { WorkoutService } from '../../workouts/workout-service';
import { WorkoutSession } from '../../workouts/workout-session-model';
import { WorkoutSessionService } from '../../workouts/workout-session-service';

interface TimeSlot {
  id: number;
  time: string;
  workout: string;
}

@Component({
  selector: 'app-calendar-detail',
  imports: [RouterLink, Search],
  templateUrl: './calendar-detail.html',
})
export class CalendarDetail {
  date = input.required<string>();

  private readonly workoutService = inject(WorkoutService);
  private readonly workoutSessionService = inject(WorkoutSessionService);

  protected readonly displayDate = computed(() => {
    const d = new Date(this.date() + 'T00:00:00');
    return {
      weekday: d.toLocaleDateString('en-US', { weekday: 'long' }),
      dayMonth: d.toLocaleDateString('en-US', { month: 'long', day: 'numeric' }),
    };
  });

  protected readonly workoutSessions = signal<WorkoutSession[]>([]);

  protected readonly timeSlots = computed<TimeSlot[]>(() =>
    this.workoutSessions()
      .map((session) => ({
        id: session.id,
        time: new Date(session.scheduledAt).toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' }),
        workout: session.workout.name,
      }))
      .sort((a, b) => a.time.localeCompare(b.time)),
  );

  protected readonly modalOpen = signal(false);

  protected readonly availableWorkouts = signal<Workout[]>([]);

  protected readonly selectedTime = signal('08:00');

  constructor() {
    effect(() => {
      this.date();
      this.loadSessions();
    });
  }

  protected openModal(): void {
    this.modalOpen.set(true);
    this.selectedTime.set('08:00');
    this.loadWorkouts();
  }

  protected onSearch(search: string): void {
    this.loadWorkouts(search);
  }

  protected onTimeChange(event: Event): void {
    this.selectedTime.set((event.target as HTMLInputElement).value);
  }

  protected selectWorkout(workout: Workout): void {
    const time = this.selectedTime() || '00:00';
    const scheduledAt = new Date(`${this.date()}T${time}:00`);

    this.workoutSessionService.create(workout.id, scheduledAt).subscribe(() => {
      this.modalOpen.set(false);
      this.loadSessions();
    });
  }

  private loadSessions(): void {
    const date = this.date();
    const startDate = new Date(`${date}T00:00:00`);
    const endDate = new Date(`${date}T23:59:59.999`);

    this.workoutSessionService
      .getAll(startDate, endDate)
      .subscribe((sessions) => this.workoutSessions.set(sessions));
  }

  private loadWorkouts(search = ''): void {
    this.workoutService.getAll(search).subscribe((workouts) => this.availableWorkouts.set(workouts));
  }
}
