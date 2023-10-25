import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthentificationService {
  private welcomeMessageSource = new BehaviorSubject<string>('');
  welcomeMessage$ = this.welcomeMessageSource.asObservable();

  constructor(private http: HttpClient) {}

  setRole(role: string) {
    localStorage.setItem('userRole', role);
  }

  isLoggedIn(): boolean {
    return !!localStorage.getItem('userRole');
  }

  getUserRole(): string | null {
    return localStorage.getItem('userRole');
  }
  
  updateWelcomeMessage(message: string) {
    this.welcomeMessageSource.next(message);
  }

  logout(logout: any) {
    return this.http.post('http://localhost:8000/api/logout', logout);
  }
  login(login: any) {
    return this.http.post('http://localhost:8000/api/login', login);
  }

}
