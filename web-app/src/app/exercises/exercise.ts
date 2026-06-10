import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable, inject } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { Exercise } from './exercise-model';

@Injectable({
  providedIn: 'root',
})
export class ExerciseService {
  private readonly http = inject(HttpClient);
  private readonly baseUrl = `${environment.apiUrl}/exercises`;

  getAll(search = ''): Observable<Exercise[]> {
    const params = search ? new HttpParams().set('search', search) : undefined;

    return this.http.get<Exercise[]>(this.baseUrl, { params });
  }

  getById(id: number): Observable<Exercise> {
    return this.http.get<Exercise>(`${this.baseUrl}/${id}`);
  }

  create(name: string): Observable<Exercise> {
    return this.http.post<Exercise>(this.baseUrl, { name });
  }

  update(id: number, name: string): Observable<Exercise> {
    return this.http.put<Exercise>(`${this.baseUrl}/${id}`, { name });
  }

  delete(id: number): Observable<void> {
    return this.http.delete<void>(`${this.baseUrl}/${id}`);
  }
}
