import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { SessionRoutingModule } from './session-routing.module';
import {  HttpClientModule } from '@angular/common/http';
import { SessionComponent } from './session.component';
import { SessionService } from './services/session.service';
import { FormsModule } from '@angular/forms';
import { NgxPaginationModule } from 'ngx-pagination';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatNativeDateModule } from '@angular/material/core';
import { MatFormFieldModule } from '@angular/material/form-field';



@NgModule({
  declarations: [
    SessionComponent
  ],
  imports: [
    CommonModule,
    SessionRoutingModule,
    HttpClientModule,
    FormsModule,
    NgxPaginationModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatFormFieldModule
  ],
  providers:[SessionService]
})
export class SessionModule { }
