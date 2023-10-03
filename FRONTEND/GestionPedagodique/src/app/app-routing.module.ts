import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [{ path: 'cours', loadChildren: () => import('./cours/cours.module').then(m => m.CoursModule) },
 { path: 'home', loadChildren: () => import('./home/home.module').then(m => m.HomeModule) },
 { path: '', loadChildren: () => import('./home/home.module').then(m => m.HomeModule) },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }