import { Component, inject, viewChild } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { ExerciseForm } from '../exercise-form/exercise-form';
import { ExerciseService } from '../exercise';

@Component({
  selector: 'app-new-exercise',
  imports: [RouterLink, ExerciseForm],
  templateUrl: './new-exercise.html',
})
export class NewExercise {
  private readonly exerciseService = inject(ExerciseService);
  private readonly router = inject(Router);

  private readonly exerciseForm = viewChild.required(ExerciseForm);

  protected save() {
    const form = this.exerciseForm().form;

    if (form.invalid) {
      form.markAllAsTouched();
      return;
    }

    this.exerciseService.create(form.value.name!).subscribe(() => {
      this.router.navigate(['/exercises']);
    });
  }
}
