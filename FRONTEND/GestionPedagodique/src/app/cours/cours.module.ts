import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CoursRoutingModule } from './cours-routing.module';
import { CoursComponent } from './cours.component';
import { CoursService } from './services/cour.service';
import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { DonneesRegroupeesService } from './services/data.service';


@NgModule({
  declarations: [
    CoursComponent
  ],
  imports: [
    CommonModule,
    CoursRoutingModule,
    HttpClientModule,
    ReactiveFormsModule,
    FormsModule,
  ],
  providers:[CoursService,DonneesRegroupeesService]
})
export class CoursModule { }
