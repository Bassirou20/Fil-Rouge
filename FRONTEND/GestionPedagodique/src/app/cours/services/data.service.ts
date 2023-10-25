import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class DonneesRegroupeesService {
  constructor(private http: HttpClient) { }

  private apiUrl = 'http://localhost:8000/api/Group_Données';


  getDonneesRegroupees() {
    return this.http.get('/Group_Données');
  }

  getProfesseurs() {
    return this.http.get(this.apiUrl);
  }

  getClasses() {
    return this.http.get(this.apiUrl);
  }

  getModules() {
    return this.http.get(this.apiUrl);
  }

  getSemestres() {
    return this.http.get(this.apiUrl);
  }
  getSalles() {
    return this.http.get(this.apiUrl);
  }
}
