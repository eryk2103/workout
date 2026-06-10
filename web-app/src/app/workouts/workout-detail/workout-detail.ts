import { Component, effect, inject, input, signal } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { List } from '../../shared/list/list';
import { ListItem } from '../../shared/list-item/list-item';
import { WorkoutService } from '../workout-service';
import { Workout } from '../workout-model';

@Component({
  selector: 'app-workout-detail',
  imports: [RouterLink, List, ListItem],
  templateUrl: './workout-detail.html',
})
export class WorkoutDetail {
  id = input.required<string>();

  private readonly workoutService = inject(WorkoutService);
  private readonly router = inject(Router);

  protected readonly workout = signal<Workout | null>(null);

  constructor() {
    effect(() => {
      this.workoutService.getById(Number(this.id())).subscribe((workout) => this.workout.set(workout));
    });
  }

  protected delete(): void {
    this.workoutService.delete(Number(this.id())).subscribe(() => {
      this.router.navigate(['/workouts']);
    });
  }
}
