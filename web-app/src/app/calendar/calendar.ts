import { Component, computed, effect, inject, signal } from '@angular/core';
import { RouterLink } from '@angular/router';
import { WorkoutSession } from '../workouts/workout-session-model';
import { WorkoutSessionService } from '../workouts/workout-session-service';

interface CalendarDay {
  date: Date;
  dayName: string;
  dayNumber: number;
  dateParam: string;
  isToday: boolean;
  sessions: WorkoutSession[];
}

@Component({
  selector: 'app-calendar',
  imports: [RouterLink],
  templateUrl: './calendar.html',
  styles: ``,
})
export class Calendar {
  private readonly workoutSessionService = inject(WorkoutSessionService);

  private readonly today = new Date();

  protected readonly selectedMonth = signal(
    new Date(this.today.getFullYear(), this.today.getMonth(), 1)
  );

  protected readonly monthYear = computed(() =>
    this.selectedMonth().toLocaleDateString('en-US', { month: 'long', year: 'numeric' })
  );

  protected readonly workoutSessions = signal<WorkoutSession[]>([]);

  private readonly sessionsByDate = computed(() => {
    const map = new Map<string, WorkoutSession[]>();

    for (const session of this.workoutSessions()) {
      const dateParam = this.toDateParam(new Date(session.scheduledAt));
      map.set(dateParam, [...(map.get(dateParam) ?? []), session]);
    }

    return map;
  });

  protected readonly days = computed(() => this.buildDays(this.selectedMonth()));

  constructor() {
    effect(() => {
      const month = this.selectedMonth();
      const startDate = new Date(month.getFullYear(), month.getMonth(), 1);
      const endDate = new Date(month.getFullYear(), month.getMonth() + 1, 0, 23, 59, 59, 999);

      this.workoutSessionService
        .getAll(startDate, endDate)
        .subscribe((sessions) => this.workoutSessions.set(sessions));
    });
  }

  protected prevMonth(): void {
    this.selectedMonth.update(d => new Date(d.getFullYear(), d.getMonth() - 1, 1));
  }

  protected nextMonth(): void {
    this.selectedMonth.update(d => new Date(d.getFullYear(), d.getMonth() + 1, 1));
  }

  private buildDays(start: Date): CalendarDay[] {
    const year = start.getFullYear();
    const month = start.getMonth();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    return Array.from({ length: daysInMonth }, (_, i) => {
      const date = new Date(year, month, i + 1);
      const dateParam = this.toDateParam(date);
      return {
        date,
        dayName: date.toLocaleDateString('en-US', { weekday: 'short' }),
        dayNumber: date.getDate(),
        dateParam,
        isToday: date.toDateString() === this.today.toDateString(),
        sessions: this.sessionsByDate().get(dateParam) ?? [],
      };
    });
  }

  private toDateParam(date: Date): string {
    const yyyy = date.getFullYear();
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const dd = String(date.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
  }
}
