import {BrowserModule} from '@angular/platform-browser';
import {LOCALE_ID, NgModule, NO_ERRORS_SCHEMA, CUSTOM_ELEMENTS_SCHEMA} from '@angular/core';
import { MDBBootstrapModule } from 'angular-bootstrap-md';
import {AppComponent} from './app.component';
import {ServiceWorkerModule} from '@angular/service-worker';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {LayoutModule} from '@angular/cdk/layout';
import {MatExpansionModule} from '@angular/material/expansion';

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
  MatTableModule
} from '@angular/material';
import {PercentPipe, registerLocaleData} from '@angular/common';
import { MatFormFieldModule } from '@angular/material';
import localeFr from '@angular/common/locales/fr';
import {AppRoutingModule} from './app-routing.module';
import {FormsModule,  ReactiveFormsModule} from '@angular/forms';
import {HttpClientModule} from '@angular/common/http';
import {HTTP_INTERCEPTORS} from '@angular/common/http';
import {AccessDeniedInterceptor} from './http-interceptors/access-denied-interceptor';
import {JwtHelperService, JwtModule} from '@auth0/angular-jwt';
import {environment} from '../environments/environment';
import {WSMain} from './shared/ws/WSMain';
import {ProjectInterceptor} from './http-interceptors/project-interceptor';
import {FlexLayoutModule} from '@angular/flex-layout';
registerLocaleData(localeFr);

import {MaterialModule} from './Utils/modules/Material.module';


@NgModule({
  declarations: [
    AppComponent,
  ],
  imports: [
    BrowserModule,
    ServiceWorkerModule.register('/ngsw-worker.js', {enabled: environment.production}),
    MDBBootstrapModule.forRoot(),
    BrowserAnimationsModule,
    LayoutModule,
    // MatToolbarModule,
    // MatButtonModule,
    // MatSidenavModule,
    // MatIconModule,
    // MatListModule,
    // MatGridListModule,
    // FlexLayoutModule,
    // MatCardModule,
    // MatExpansionModule,
    MatMenuModule,
    // MatFormFieldModule,
    // MatSelectModule,
    // MatCheckboxModule,
    // ReactiveFormsModule,
    // MatButtonToggleModule,
    // MatInputModule,
    // MatPaginatorModule,
    // MatRadioModule,
    // MatDatepickerModule,
    // MatTableModule,
    AppRoutingModule,
    MaterialModule,
    HttpClientModule,
    FormsModule,
    JwtModule.forRoot({
      config: {
        whitelistedDomains: ['localhost:4200', 'prfnapp01:8080'],
        blacklistedRoutes: ['localhost:4200/login', 'prfnapp01:8080/login']
      }
    })
  ],
    schemas: [NO_ERRORS_SCHEMA, CUSTOM_ELEMENTS_SCHEMA],
  providers: [{
    provide: HTTP_INTERCEPTORS,
    useClass: ProjectInterceptor,
    multi: true
  },
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AccessDeniedInterceptor,
      multi: true
    },
    WSMain,
    JwtHelperService,
    {provide: LOCALE_ID, useValue: 'fr-FR'},
    PercentPipe],
  bootstrap: [AppComponent],
  entryComponents: []
})
export class AppModule {
}
