import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable, inject } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { ExerciseSession } from './exercise-session-model';

export interface CreateExerciseSession {
  exerciseId: number;
  scheduledAt: Date;
  reps?: number;
  set?: number;
  weight?: number;
  workoutSessionId?: number;
}

export interface UpdateExerciseSession {
  scheduledAt: Date;
  reps?: number;
  set?: number;
  weight?: number;
  startAt?: Date;
  endAt?: Date;
}

@Injectable({
  providedIn: 'root',
})
export class ExerciseSessionService {
  private readonly http = inject(HttpClient);
  private readonly baseUrl = `${environment.apiUrl}/exercise-sessions`;

  getAll(workoutSessionId?: number): Observable<ExerciseSession[]> {
    let params = new HttpParams();

    if (workoutSessionId !== undefined) {
      params = params.set('workoutSessionId', workoutSessionId);
    }

    return this.http.get<ExerciseSession[]>(this.baseUrl, { params });
  }

  getById(id: number): Observable<ExerciseSession> {
    return this.http.get<ExerciseSession>(`${this.baseUrl}/${id}`);
  }

  create(session: CreateExerciseSession): Observable<ExerciseSession> {
    return this.http.post<ExerciseSession>(this.baseUrl, {
      ...session,
      scheduledAt: session.scheduledAt.toISOString(),
    });
  }

  update(id: number, session: UpdateExerciseSession): Observable<ExerciseSession> {
    return this.http.put<ExerciseSession>(`${this.baseUrl}/${id}`, {
      ...session,
      scheduledAt: session.scheduledAt.toISOString(),
      startAt: session.startAt?.toISOString(),
      endAt: session.endAt?.toISOString(),
    });
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/${id}`);
  }
}
