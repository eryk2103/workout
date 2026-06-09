import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { List } from '../shared/list/list';
import { ListItem } from '../shared/list-item/list-item';
import { Search } from '../shared/search/search';

@Component({
  selector: 'app-exercises',
  imports: [RouterLink, Search, List, ListItem],
  templateUrl: './exercises.html',
  styles: ``,
})
export class Exercises {
  protected readonly exercises = [
    'Bench Press',
    'Squat',
    'Deadlift',
    'Overhead Press',
    'Pull-Up',
    'Barbell Row',
    'Dumbbell Curl',
    'Tricep Dip',
  ];
}
