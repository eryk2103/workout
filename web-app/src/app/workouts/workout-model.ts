import { Exercise } from '../exercises/exercise-model';

export interface Workout {
  id: number;
  name: string;
  exercises: Exercise[];
}
