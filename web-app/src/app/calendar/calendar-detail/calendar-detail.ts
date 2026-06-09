import { Component, computed, inject, input, signal } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { Search } from '../../shared/search/search';
import { List } from '../../shared/list/list';

interface TimeSlot {
  time: string;
  workout: string;
}

@Component({
  selector: 'app-calendar-detail',
  imports: [RouterLink, Search, List],
  templateUrl: './calendar-detail.html',
})
export class CalendarDetail {
  date = input.required<string>();

  private readonly router = inject(Router);

  protected readonly displayDate = computed(() => {
    const d = new Date(this.date() + 'T00:00:00');
    return {
      weekday: d.toLocaleDateString('en-US', { weekday: 'long' }),
      dayMonth: d.toLocaleDateString('en-US', { month: 'long', day: 'numeric' }),
    };
  });

  protected readonly timeSlots: TimeSlot[] = this.buildTimeSlots();

  protected readonly modalOpen = signal(false);

  protected readonly availableWorkouts = [
    'Push Day', 'Pull Day', 'Leg Day', 'Full Body',
    'Cardio', 'Stretching', 'Core & Cardio', 'Active Recovery',
  ];

  protected selectWorkout(name: string): void {
    this.modalOpen.set(false);
    this.router.navigate(['/workout-log', name]);
  }

  private buildTimeSlots(): TimeSlot[] {
    const scheduled: Record<string, string> = {
      '09:00': 'Full Body',
      '13:00': 'Cardio',
      '17:00': 'Stretching',
    };

    return Object.entries(scheduled).map(([time, workout]) => ({ time, workout }));
  }
}
