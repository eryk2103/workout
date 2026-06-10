import { WorkoutSession } from '../workouts/workout-session-model';
import { Exercise } from './exercise-model';

export interface ExerciseSession {
  id: number;
  exercise: Exercise;
  scheduledAt: string;
  reps: number | null;
  set: number | null;
  weight: number | null;
  startAt: string | null;
  endAt: string | null;
  workoutSession: WorkoutSession | null;
}
