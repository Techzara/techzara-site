import {HttpEvent, HttpHandler, HttpHeaders, HttpInterceptor, HttpRequest} from '@angular/common/http';
import {Injectable} from '@angular/core';
import {Observable} from 'rxjs';
import {Constants} from '../Utils/Constants';

@Injectable()
export class ProjectInterceptor implements HttpInterceptor {
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    const authReq = req.clone(
      {
        headers: req.headers
          .set('X-ProjectName', Constants.APP_NAME)
          .set('X-ProjectVersion', Constants.APP_VERSION)
          .set('Authorization', 'Bearer ' + localStorage.getItem('token') )
      }
    );
    return next.handle(authReq);
  }
}
