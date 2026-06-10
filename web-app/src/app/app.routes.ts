import { Routes } from '@angular/router';

export const routes: Routes = [
  { path: 'calendar', loadComponent: () => import('./calendar/calendar').then(m => m.Calendar) },
  { path: 'calendar/:date', loadComponent: () => import('./calendar/calendar-detail/calendar-detail').then(m => m.CalendarDetail) },
  { path: 'workouts', loadComponent: () => import('./workouts/workouts').then(m => m.Workouts) },
  { path: 'workouts/new', loadComponent: () => import('./workouts/new-workout/new-workout').then(m => m.NewWorkout) },
  { path: 'exercises', loadComponent: () => import('./exercises/exercises/exercises').then(m => m.Exercises) },
  { path: 'exercises/new', loadComponent: () => import('./exercises/new-exercise/new-exercise').then(m => m.NewExercise) },
  { path: 'workout-log/:name', loadComponent: () => import('./workout-log/workout-log').then(m => m.WorkoutLog) },
  { path: '', redirectTo: 'calendar', pathMatch: 'full' },
];
