import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs/index';
import {catchError} from 'rxjs/internal/operators';
import {Injectable} from '@angular/core';
import {AuthenticationJsonResponse, JsonResponse} from './json-response';
import {Constants} from '../../Utils/Constants';
import {WsReturnCode} from '../enum/ws-return-code.enum';

@Injectable()
export class WSMain {
  private httpMain: HttpClient;

  constructor(_httpMain: HttpClient) {
    this.httpMain = _httpMain;
  }

  get(url: string): Observable<JsonResponse> {
    return this.httpMain.get<JsonResponse | AuthenticationJsonResponse>(url).pipe(
      catchError(this.handleError('get', new JsonResponse(WsReturnCode.NOT_FOUND, 'server not found')))
    );
  }

  post(url: string, param: any): Observable<JsonResponse | AuthenticationJsonResponse> {
    const finalParam = Object.assign({
      projectName: Constants.APP_NAME,
      projectVersion: Constants.APP_VERSION
    }, param);
    return this.httpMain.post<any>(url, finalParam).pipe(
      catchError(this.handleError('post', new JsonResponse(WsReturnCode.NOT_FOUND, 'server not found')))
    );
  }

  /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T>(operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      // console.error(error); // log to console instead

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }
}
