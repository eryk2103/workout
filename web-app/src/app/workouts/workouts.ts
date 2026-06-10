import { Component, inject, signal } from '@angular/core';
import { RouterLink } from '@angular/router';
import { List } from '../shared/list/list';
import { ListItem } from '../shared/list-item/list-item';
import { Search } from '../shared/search/search';
import { WorkoutService } from './workout-service';
import { Workout } from './workout-model';

@Component({
  selector: 'app-workouts',
  imports: [RouterLink, Search, List, ListItem],
  templateUrl: './workouts.html',
  styles: ``,
})
export class Workouts {
  private readonly workoutService = inject(WorkoutService);

  protected readonly workouts = signal<Workout[]>([]);

  constructor() {
    this.loadWorkouts();
  }

  protected onSearch(search: string) {
    this.loadWorkouts(search);
  }

  private loadWorkouts(search = '') {
    this.workoutService.getAll(search).subscribe((workouts) => this.workouts.set(workouts));
  }
}
