import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { WorkoutForm } from '../workout-form/workout-form';

@Component({
  selector: 'app-new-workout',
  imports: [RouterLink, WorkoutForm],
  templateUrl: './new-workout.html',
})
export class NewWorkout {}
