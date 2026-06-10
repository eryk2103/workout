import { Component, computed, effect, inject, input, signal } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { Search } from '../../shared/search/search';
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

  private readonly router = inject(Router);
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

  protected readonly availableWorkouts = [
    'Push Day', 'Pull Day', 'Leg Day', 'Full Body',
    'Cardio', 'Stretching', 'Core & Cardio', 'Active Recovery',
  ];

  constructor() {
    effect(() => {
      const date = this.date();
      const startDate = new Date(`${date}T00:00:00`);
      const endDate = new Date(`${date}T23:59:59.999`);

      this.workoutSessionService
        .getAll(startDate, endDate)
        .subscribe((sessions) => this.workoutSessions.set(sessions));
    });
  }

  protected selectWorkout(name: string): void {
    this.modalOpen.set(false);
    this.router.navigate(['/workout-log', name]);
  }
}
