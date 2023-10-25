import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CoursService {
  private apiUrl = 'http://localhost:8000/api/cours';
  private url ='http://localhost:8000/api/Planning_session'

  constructor(private http: HttpClient) {}

  getCours(): Observable<any> {
    return this.http.get(this.apiUrl);
  }

  ajouterCours(coursData: any) {
    return this.http.post(this.apiUrl, coursData);
  }

  ajouterSession(coursData: any) {
    return this.http.post(this.url, coursData);
  }
}
