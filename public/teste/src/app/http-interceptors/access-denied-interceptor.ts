import { HTTP_INTERCEPTORS, HttpEvent, HttpHandler, HttpInterceptor, HttpRequest } from '@angular/common/http';
import { ExistingProvider, Injectable } from '@angular/core';
import { Observable, ReplaySubject, throwError } from 'rxjs';
import { catchError, finalize, map } from 'rxjs/operators';
import {HttpErrorResponse} from '@angular/common/http';
import {Router} from '@angular/router';


@Injectable({
  providedIn: 'root'
})
export class AccessDeniedInterceptor implements HttpInterceptor {

  constructor(  private router: Router) {

  }
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

    return next.handle(req).pipe(
      catchError(error => {
        console.log('AccessDeniedInterceptor > error', error);
        if (error instanceof HttpErrorResponse) {
          if (error.status === 401) {
            localStorage.removeItem('access_token');
            this.router.navigate(['/login']);
          }
        }
        return throwError(error);
      })
    );
  }
}
