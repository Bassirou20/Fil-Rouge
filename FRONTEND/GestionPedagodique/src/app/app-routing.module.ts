import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AuthGuard} from './auth.guard';

const routes: Routes = [
  { path: 'cours', loadChildren: () => import('./cours/cours.module').then(m => m.CoursModule),canActivate: [AuthGuard], data: { role: ['RP'] } },
 { path: 'home', loadChildren: () => import('./home/home.module').then(m => m.HomeModule) , canActivate: [AuthGuard], data: { role: ['RP', 'Attache'] }  },
 { path: '', loadChildren: () => import('./login/login.module').then(m => m.LoginModule) },
 { path: 'Session', loadChildren: () => import('./session/session.module').then(m => m.SessionModule) ,canActivate: [AuthGuard], data: { role: ['RP','Attache'] }},
 { path: 'login', loadChildren: () => import('./login/login.module').then(m => m.LoginModule) },
 { path: 'etudiant', loadChildren: () => import('./etudiant/etudiant.module').then(m => m.EtudiantModule),canActivate: [AuthGuard], data: { role: ['RP','Attache'] } },

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
