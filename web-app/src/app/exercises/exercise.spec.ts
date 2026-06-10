import { HttpTestingController, provideHttpClientTesting } from '@angular/common/http/testing';
import { provideHttpClient } from '@angular/common/http';
import { TestBed } from '@angular/core/testing';
import { environment } from '../../environments/environment';
import { ExerciseService } from './exercise';
import { Exercise } from './exercise-model';

describe('ExerciseService', () => {
  let service: ExerciseService;
  let httpMock: HttpTestingController;
  const baseUrl = `${environment.apiUrl}/exercises`;

  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [provideHttpClient(), provideHttpClientTesting()],
    });

    service = TestBed.inject(ExerciseService);
    httpMock = TestBed.inject(HttpTestingController);
  });

  afterEach(() => {
    httpMock.verify();
  });

  it('should create', () => {
    expect(service).toBeTruthy();
  });

  it('should get all exercises', () => {
    const exercises: Exercise[] = [{ id: 1, name: 'Bench Press' }];

    service.getAll().subscribe((result) => {
      expect(result).toEqual(exercises);
    });

    const req = httpMock.expectOne(baseUrl);
    expect(req.request.method).toBe('GET');
    req.flush(exercises);
  });

  it('should get exercises filtered by search', () => {
    service.getAll('bench').subscribe();

    const req = httpMock.expectOne((request) => request.url === baseUrl && request.params.get('search') === 'bench');
    expect(req.request.method).toBe('GET');
    req.flush([]);
  });

  it('should get an exercise by id', () => {
    const exercise: Exercise = { id: 1, name: 'Bench Press' };

    service.getById(1).subscribe((result) => {
      expect(result).toEqual(exercise);
    });

    const req = httpMock.expectOne(`${baseUrl}/1`);
    expect(req.request.method).toBe('GET');
    req.flush(exercise);
  });

  it('should create an exercise', () => {
    const exercise: Exercise = { id: 1, name: 'Squat' };

    service.create('Squat').subscribe((result) => {
      expect(result).toEqual(exercise);
    });

    const req = httpMock.expectOne(baseUrl);
    expect(req.request.method).toBe('POST');
    expect(req.request.body).toEqual({ name: 'Squat' });
    req.flush(exercise);
  });

  it('should update an exercise', () => {
    const exercise: Exercise = { id: 1, name: 'Front Squat' };

    service.update(1, 'Front Squat').subscribe((result) => {
      expect(result).toEqual(exercise);
    });

    const req = httpMock.expectOne(`${baseUrl}/1`);
    expect(req.request.method).toBe('PUT');
    expect(req.request.body).toEqual({ name: 'Front Squat' });
    req.flush(exercise);
  });

  it('should delete an exercise', () => {
    service.delete(1).subscribe();

    const req = httpMock.expectOne(`${baseUrl}/1`);
    expect(req.request.method).toBe('DELETE');
    req.flush(null);
  });
});
