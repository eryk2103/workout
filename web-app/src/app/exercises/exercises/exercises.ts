import { Component, inject, signal } from '@angular/core';
import { RouterLink } from '@angular/router';
import { List } from '../../shared/list/list';
import { ListItem } from '../../shared/list-item/list-item';
import { Search } from '../../shared/search/search';
import { ExerciseService } from '../exercise';
import { Exercise } from '../exercise-model';

@Component({
  selector: 'app-exercises',
  imports: [RouterLink, Search, List, ListItem],
  templateUrl: './exercises.html',
  styles: ``,
})
export class Exercises {
  private readonly exerciseService = inject(ExerciseService);

  protected readonly exercises = signal<Exercise[]>([]);

  constructor() {
    this.loadExercises();
  }

  protected onSearch(search: string) {
    this.loadExercises(search);
  }

  private loadExercises(search = '') {
    this.exerciseService.getAll(search).subscribe((exercises) => this.exercises.set(exercises));
  }
}
