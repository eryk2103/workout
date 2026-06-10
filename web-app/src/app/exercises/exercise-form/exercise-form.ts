import { Component, inject } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';

@Component({
  selector: 'app-exercise-form',
  imports: [ReactiveFormsModule],
  templateUrl: './exercise-form.html',
})
export class ExerciseForm {
  private readonly fb = inject(FormBuilder);

  readonly form = this.fb.group({
    name: ['', Validators.required],
  });
}
