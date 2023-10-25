import { Injectable } from '@angular/core';
import { CanActivateFn } from '@angular/router';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot, UrlTree, Router } from '@angular/router';
import { AuthentificationService } from './auth/authentification.service';


@Injectable({
  providedIn: 'root'
})

export class AuthGuard implements CanActivate {
  // return true;
  constructor(private authService: AuthentificationService, private router: Router) {}

  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): boolean {
    const requiredRoles = next.data?.['role'] as string[];
    console.log(next);

    const userRole = this.authService.getUserRole();

    if (this.authService.isLoggedIn() && userRole && requiredRoles.includes(userRole)) {
      return true;
    } else {
      this.router.navigate(['/access-denied']);
      return false;
    }
  }

};
