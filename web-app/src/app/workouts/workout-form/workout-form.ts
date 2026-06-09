import { Component, computed, inject, signal } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { ExerciseForm } from '../../exercises/exercise-form/exercise-form';

@Component({
  selector: 'app-workout-form',
  imports: [ReactiveFormsModule, ExerciseForm],
  templateUrl: './workout-form.html',
})
export class WorkoutForm {
  private readonly fb = inject(FormBuilder);

  protected readonly form = this.fb.group({
    name: ['', Validators.required],
  });

  protected readonly availableExercises = [
    'Bench Press', 'Squat', 'Deadlift', 'Overhead Press',
    'Pull-Up', 'Barbell Row', 'Dumbbell Curl', 'Tricep Dip',
  ];

  protected readonly selectedExercises = signal<Set<string>>(new Set());
  protected readonly exerciseQuery = signal('');
  protected readonly newExerciseModalOpen = signal(false);

  protected readonly filteredExercises = computed(() => {
    const q = this.exerciseQuery().toLowerCase();
    return q ? this.availableExercises.filter(e => e.toLowerCase().includes(q)) : this.availableExercises;
  });

  protected readonly selectedExerciseList = computed(() => [...this.selectedExercises()]);

  protected toggleExercise(name: string): void {
    this.selectedExercises.update(set => {
      const next = new Set(set);
      next.has(name) ? next.delete(name) : next.add(name);
      return next;
    });
  }
}
