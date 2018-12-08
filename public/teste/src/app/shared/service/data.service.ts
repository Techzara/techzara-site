import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {DataResponse} from '../model/DataResponse';
import {Observable, of} from 'rxjs/index';
import {catchError, tap} from 'rxjs/internal/operators';
import {isNullOrUndefined} from 'util';

@Injectable({
  providedIn: 'root'
})

/**
 * Create by Tahiana
 * tahiana0@gmail.com
 */
export class DataService {

  /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      console.error(error); // log to console instead

      // TODO: better job of transforming error for user consumption
      console.log(`${operation} failed: ${error.message}`);

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  constructor(private http: HttpClient) { }

  /**
   * Get data from server
   * @param {string} fromUrl <url>
   * @returns {Observable<DataResponse>}
   */
  get(fromUrl: string): Observable<DataResponse> {
    console.log('we are adding shared service');
    return this.http.get<DataResponse>(fromUrl).pipe(
      tap((response: DataResponse) => {
        console.log('Get service');
      }),
      catchError(this.handleError<DataResponse>('Get service'))
    );
  }

  /**
   *  Post object to server
   * @param {string} fromUrl <url>
   * @param body <Object to post>
   * @param options <http headers, params...>
   * @returns {Observable<DataResponse>}
   */
  post(fromUrl: string, body: any = null, options: any = null):  Observable<DataResponse> {
    options = (isNullOrUndefined(options)) ? { headers : new HttpHeaders()} : options;
    return this.http.post<DataResponse>(fromUrl, body, options).pipe(
      tap((response: DataResponse) => {
        console.log('Post Service');
      }),
      catchError(this.handleError<DataResponse>('Post service'))
    );
  }

  /**
   *  Put object to server
   * @param {string} fromUrl <url>
   * @param {any} body <Object to post>
   * @param {any} options <http headers, params...>
   * @returns {Observable<DataResponse>}
   */
  // put(fromUrl: string, body: any = null, options: any = null): Observable<any> {
  //   options = (isNullOrUndefined(options)) ? { headers : new HttpHeaders()} : options;
  //   return this.http.put<any>(fromUrl, body, options).pipe(
  //     tap(res => console.log('update service' + res)),
  //     catchError(this.handleError<any>('update service'))
  //   );
  // }

  /**
   * Delete object on server
   * @param {string} fromUrl <url>
   * @param {any | number} body <Object or id to delete>
   * @param {any} options <http headers, params...>
   * @returns {Observable<DataResponse>}
   */
  // delete(fromUrl: string, body: any | number = null, options: any = null): Observable<DataResponse> {
  //   options = (isNullOrUndefined(options)) ? { headers : new HttpHeaders()} : options;
  //   return this.http.delete<DataResponse>(fromUrl, options).pipe(
  //     tap(_ => console.log('deleted article')),
  //     catchError(this.handleError<DataResponse>('Delete article'))
  //   );
  // }

  /**
   *  Find one or more object by field on server
   * @param {string} fromUrl <url>
   * @param {any} body <field, value to find>
   * @param {any} options <http headers, params...>
   * @returns {Observable<DataResponse>}
   */
  findBy(fromUrl: string, body: any = null, options: any = null): Observable<DataResponse> {
    options = (isNullOrUndefined(options)) ? { headers : new HttpHeaders()} : options;
    return this.http.post<DataResponse>(fromUrl, body, options).pipe(
      tap((response: DataResponse) => {
        console.log('FindBy Service');
      }),
      catchError(this.handleError<DataResponse>('FindBy service'))
    );
  }
}
