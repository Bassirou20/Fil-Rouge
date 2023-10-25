import { Component, OnDestroy, OnInit } from '@angular/core';
import { AuthentificationService } from '../auth/authentification.service';
import { NavbarService } from '../components/navbar/services/navbar.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
})
export class LoginComponent {
  email = '';
  password = '';
  public welcomeMessage: string = '';

  constructor(
    private authService: AuthentificationService,
    private NavbarService: NavbarService,
    private router: Router
  ) {}

  ngOnDestroy(): void {
    this.NavbarService.display();
  }

  ngOnInit(): void {
    this.NavbarService.hide();
  }
  login() {
    const credentials = {
      email: this.email,
      password: this.password,
    };

    this.authService.login(credentials).subscribe(
      (response: any) => {
        this.authService.setRole(response.user.role);
          if(response.user.role=="RP"){

            this.router.navigate(['/cours']);
          }else{
            this.router.navigate(['/Session']);

          }
        console.log(response);
        this.authService.updateWelcomeMessage('Bienvenue, ' + response.user.name + ' !');
      },
      (error) => {
        console.error("Erreur d'authentification :", error);
      }
    );
  }
}
