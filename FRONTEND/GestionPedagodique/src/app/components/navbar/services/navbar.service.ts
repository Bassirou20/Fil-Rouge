import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class NavbarService {
  showNavbar: BehaviorSubject<boolean>;
  http: any;
  constructor() {
    this.showNavbar = new BehaviorSubject<boolean>(true);
  }

  hide() {
    this.showNavbar.next(false);
  }

  display() {
    this.showNavbar.next(true);
  }

  logout() {
    // Envoyez une requête HTTP pour la déconnexion vers l'URL appropriée
    this.http.post('http://localhost:8000/api/logout', {}).subscribe(
      (response: any) => {
        // Déconnexion réussie, effectuez les actions nécessaires ici
        // Par exemple, supprimez les informations d'authentification, redirigez l'utilisateur, etc.

        // Une fois la déconnexion terminée, vous pouvez masquer la barre de navigation
        this.hide();
      },
      (error: any) => {
        console.error('Erreur de déconnexion :', error);
      }
    );
  }
}
