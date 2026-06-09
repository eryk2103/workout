import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { ExerciseForm } from '../exercise-form/exercise-form';

@Component({
  selector: 'app-new-exercise',
  imports: [RouterLink, ExerciseForm],
  templateUrl: './new-exercise.html',
})
export class NewExercise {}
