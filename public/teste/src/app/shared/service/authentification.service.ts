import { Injectable } from '@angular/core';
@Injectable({
  providedIn: 'root'
})

export class AuthentificationService {
  constructor() { }
  private loggedInStatus = false;

  setLoggedIn(value: boolean) {
  this.loggedInStatus = value;
 }
  get isLoggedIn() {
  return this.loggedInStatus;
 }
  logout() {
    // remove token from local storage to log user out
    localStorage.removeItem('token');
    this.setLoggedIn(false);
  }
}
