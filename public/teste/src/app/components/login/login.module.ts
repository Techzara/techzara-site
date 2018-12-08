import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import {
  MatToolbarModule,
  MatButtonModule,
  MatSidenavModule,
  MatIconModule,
  MatListModule,
  MatGridListModule,
  MatCardModule,
  MatMenuModule,
  MatSelectModule,
  MatCheckboxModule,
  MatButtonToggleModule,
  MatInputModule,
  MatPaginatorModule,
  MatRadioModule,
  MatDatepickerModule,
  MatTableModule, MatFormFieldModule
} from '@angular/material';
import { LoginRoutingModule } from './login-routing.module';
import { LoginComponent } from './login.component';
import {ReactiveFormsModule} from '@angular/forms';
import {FlexLayoutModule} from '@angular/flex-layout';
import {MatExpansionModule} from '@angular/material/expansion';
import { HeaderComponent } from './header/header.component';

@NgModule({
  imports: [CommonModule,
    MatToolbarModule,
    MatButtonModule,
    MatSidenavModule,
    MatIconModule,
    FormsModule,
    MatListModule,
    MatGridListModule,
    FlexLayoutModule,
    MatCardModule,
    MatExpansionModule,
    MatMenuModule,
    MatFormFieldModule,
    MatSelectModule,
    MatCheckboxModule,
    ReactiveFormsModule,
    MatButtonToggleModule,
    MatInputModule,
    MatPaginatorModule,
    MatRadioModule,
    MatDatepickerModule,
    MatTableModule,
    LoginRoutingModule],
  declarations: [LoginComponent, HeaderComponent]
})
export class LoginModule {}
