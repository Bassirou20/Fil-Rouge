
import { Component, OnDestroy } from '@angular/core';
import { SessionService } from 'src/app/session/services/session.service';
import { NavbarService } from './services/navbar.service';
import { Observable, Subscription } from 'rxjs';
import { AuthentificationService } from 'src/app/auth/authentification.service';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnDestroy {
  showNavbar: boolean = true;
  userRole: string | null = "RP";
  subscribe: Subscription;
  isModalOpen = false;
  selectedExcelFile: File | null = null;
  authService: any;
  router: any;

  constructor(private sessionService: SessionService, private navbarService: NavbarService,authService: AuthentificationService) {
    this.subscribe = this.navbarService.showNavbar.subscribe((value) => {
      this.showNavbar = value;
    });
  }

  logout() {
    this.authService.logout();
    // Redirigez l'utilisateur vers la page de connexion ou une autre page de votre choix.
    // Par exemple, si vous avez une route pour la page de connexion :
    this.router.navigate(['/login']);
  }

  ngOnDestroy(): void {
    this.subscribe.unsubscribe();
  }

  openModal() {
    this.isModalOpen = true;
  }

  closeModal() {
    this.isModalOpen = false;
    this.selectedExcelFile = null;
  }

  handleFileInput(event: any) {
    this.selectedExcelFile = event.target.files[0];
  }

  importStudents() {
    if (this.selectedExcelFile) {
      const file = new FormData();
      file.append('file', this.selectedExcelFile as File);

      this.sessionService.ajouterfichier(file).subscribe(
        (response) => {
          console.log('Étudiants importés avec succès :', response);
          this.closeModal();
        },
        (error) => {
          console.error('Erreur lors de l\'importation des étudiants :', error);
        }
      );
    }
  }
}
