import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { List } from '../shared/list/list';
import { ListItem } from '../shared/list-item/list-item';
import { Search } from '../shared/search/search';

@Component({
  selector: 'app-workouts',
  imports: [RouterLink, Search, List, ListItem],
  templateUrl: './workouts.html',
  styles: ``,
})
export class Workouts {
  protected readonly workouts = [
    'Push Day',
    'Pull Day',
    'Leg Day',
    'Upper Body',
    'Lower Body',
    'Full Body',
    'Core & Cardio',
    'Active Recovery',
  ];
}
