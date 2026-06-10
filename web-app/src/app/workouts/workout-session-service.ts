import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable, inject } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { WorkoutSession } from './workout-session-model';

@Injectable({
  providedIn: 'root',
})
export class WorkoutSessionService {
  private readonly http = inject(HttpClient);
  private readonly baseUrl = `${environment.apiUrl}/workout-sessions`;

  getAll(startDate?: Date, endDate?: Date): Observable<WorkoutSession[]> {
    let params = new HttpParams();

    if (startDate) {
      params = params.set('startDate', startDate.toISOString());
    }

    if (endDate) {
      params = params.set('endDate', endDate.toISOString());
    }

    return this.http.get<WorkoutSession[]>(this.baseUrl, { params });
  }

  getById(id: number): Observable<WorkoutSession> {
    return this.http.get<WorkoutSession>(`${this.baseUrl}/${id}`);
  }

  create(workoutId: number, scheduledAt: Date): Observable<WorkoutSession> {
    return this.http.post<WorkoutSession>(this.baseUrl, {
      workoutId,
      scheduledAt: scheduledAt.toISOString(),
    });
  }

  update(id: number, scheduledAt: Date): Observable<WorkoutSession> {
    return this.http.put<WorkoutSession>(`${this.baseUrl}/${id}`, {
      scheduledAt: scheduledAt.toISOString(),
    });
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/${id}`);
  }
}
