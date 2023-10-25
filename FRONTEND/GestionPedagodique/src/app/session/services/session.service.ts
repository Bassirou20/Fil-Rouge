import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class SessionService {
  private api = 'http://localhost:8000/api';
  private apiUrl = 'http://localhost:8000/api/Planning_session';
  private url = 'http://localhost:8000/api/Group_Données';
  private urlExcel = 'http://localhost:8000/api/importer';
  private annulation = 'http://localhost:8000/api/sessions/23/annuler';

  constructor(private http: HttpClient) {}

  getSession(): Observable<any> {
    return this.http.get(this.apiUrl);
  }

  getSalle(): Observable<any> {
    return this.http.get(this.url);
  }

  ajouterSession(coursData: any) {
    return this.http.post(this.apiUrl, coursData);
  }

  ajouterfichier(coursData: any) {
    return this.http.post(this.urlExcel, coursData);
  }

  annulerSession(sessionId: number) {
    return this.http.post(
      'http://localhost:8000/api/sessions/${sessionId}/annuler',
      {}
    );
  }
}
