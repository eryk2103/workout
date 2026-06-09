import { Component, computed, signal } from '@angular/core';
import { RouterLink } from '@angular/router';

interface CalendarDay {
  date: Date;
  dayName: string;
  dayNumber: number;
  dateParam: string;
  isToday: boolean;
}

@Component({
  selector: 'app-calendar',
  imports: [RouterLink],
  templateUrl: './calendar.html',
  styles: ``,
})
export class Calendar {
  private readonly today = new Date();

  protected readonly selectedMonth = signal(
    new Date(this.today.getFullYear(), this.today.getMonth(), 1)
  );

  protected readonly monthYear = computed(() =>
    this.selectedMonth().toLocaleDateString('en-US', { month: 'long', year: 'numeric' })
  );

  protected readonly days = computed(() => this.buildDays(this.selectedMonth()));

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
      const mm = String(month + 1).padStart(2, '0');
      const dd = String(i + 1).padStart(2, '0');
      return {
        date,
        dayName: date.toLocaleDateString('en-US', { weekday: 'short' }),
        dayNumber: date.getDate(),
        dateParam: `${year}-${mm}-${dd}`,
        isToday: date.toDateString() === this.today.toDateString(),
      };
    });
  }
}
