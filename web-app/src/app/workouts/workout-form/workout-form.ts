import { Component, computed, inject, signal, viewChild } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { ExerciseForm } from '../../exercises/exercise-form/exercise-form';
import { ExerciseService } from '../../exercises/exercise-service';
import { Exercise } from '../../exercises/exercise-model';

@Component({
  selector: 'app-workout-form',
  imports: [ReactiveFormsModule, ExerciseForm],
  templateUrl: './workout-form.html',
})
export class WorkoutForm {
  private readonly fb = inject(FormBuilder);
  private readonly exerciseService = inject(ExerciseService);

  private readonly newExerciseForm = viewChild(ExerciseForm);

  readonly form = this.fb.group({
    name: ['', Validators.required],
  });

  protected readonly availableExercises = signal<Exercise[]>([]);

  protected readonly selectedExercises = signal<Set<number>>(new Set());
  protected readonly exerciseQuery = signal('');
  protected readonly newExerciseModalOpen = signal(false);

  protected readonly filteredExercises = computed(() => {
    const q = this.exerciseQuery().toLowerCase();
    return q
      ? this.availableExercises().filter((e) => e.name.toLowerCase().includes(q))
      : this.availableExercises();
  });

  protected readonly selectedExerciseList = computed(() =>
    this.availableExercises().filter((e) => this.selectedExercises().has(e.id)),
  );

  readonly selectedExerciseIds = computed(() => [...this.selectedExercises()]);

  constructor() {
    this.loadExercises();
  }

  protected toggleExercise(id: number): void {
    this.selectedExercises.update(set => {
      const next = new Set(set);
      next.has(id) ? next.delete(id) : next.add(id);
      return next;
    });
  }

  protected saveNewExercise(): void {
    const form = this.newExerciseForm()?.form;

    if (!form || form.invalid) {
      form?.markAllAsTouched();
      return;
    }

    this.exerciseService.create(form.value.name!).subscribe((exercise) => {
      this.availableExercises.update(exercises => [...exercises, exercise]);
      this.selectedExercises.update(set => new Set(set).add(exercise.id));
      form.reset();
      this.newExerciseModalOpen.set(false);
    });
  }

  private loadExercises(): void {
    this.exerciseService.getAll().subscribe((exercises) => this.availableExercises.set(exercises));
  }
}
