import { Component, inject, viewChild } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { WorkoutForm } from '../workout-form/workout-form';
import { WorkoutService } from '../workout-service';

@Component({
  selector: 'app-new-workout',
  imports: [RouterLink, WorkoutForm],
  templateUrl: './new-workout.html',
})
export class NewWorkout {
  private readonly workoutService = inject(WorkoutService);
  private readonly router = inject(Router);

  private readonly workoutForm = viewChild.required(WorkoutForm);

  protected save() {
    const workoutForm = this.workoutForm();
    const form = workoutForm.form;

    if (form.invalid) {
      form.markAllAsTouched();
      return;
    }

    this.workoutService.create(form.value.name!, workoutForm.selectedExerciseIds()).subscribe(() => {
      this.router.navigate(['/workouts']);
    });
  }
}
