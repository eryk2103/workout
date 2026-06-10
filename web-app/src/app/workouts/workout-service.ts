import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable, inject } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { Workout } from './workout-model';

@Injectable({
  providedIn: 'root',
})
export class WorkoutService {
  private readonly http = inject(HttpClient);
  private readonly baseUrl = `${environment.apiUrl}/workouts`;

  getAll(search = ''): Observable<Workout[]> {
    const params = search ? new HttpParams().set('search', search) : undefined;

    return this.http.get<Workout[]>(this.baseUrl, { params });
  }

  getById(id: number): Observable<Workout> {
    return this.http.get<Workout>(`${this.baseUrl}/${id}`);
  }

  create(name: string, exercisesIds: number[]): Observable<Workout> {
    return this.http.post<Workout>(this.baseUrl, { name, exercisesIds });
  }

  update(id: number, name: string, exercisesIds: number[]): Observable<Workout> {
    return this.http.put<Workout>(`${this.baseUrl}/${id}`, { name, exercisesIds });
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/${id}`);
  }
}
