import { Workout } from './workout-model';

export interface WorkoutSession {
  id: number;
  scheduledAt: string;
  workout: Workout;
}
