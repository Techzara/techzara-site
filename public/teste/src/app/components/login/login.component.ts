import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import {AuthentificationService} from '../../shared/service/authentification.service';
import {Login} from '../../shared/model/login';
import {DataService} from '../../shared/service/data.service';
import {urlList} from '../../Utils/api/urlList';
import {ConstantHTTP} from '../../Utils/ConstantHTTP';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  hide = true;
  title = 'Techzara Ny Sekoliko';
  login: Login;
  submitted: boolean;
  error: string;
  loading: boolean;
  constructor(private router: Router,
              private authData: AuthentificationService,
              private dataService: DataService) { }

  ngOnInit() {
    this.login = new Login();
    this.loading = false;
    this.authData.setLoggedIn(false);
    localStorage.clear();
  }
  onclick() {
  }
  onSubmit() {
    this.submitted = true;
  }
  auth(login: Login) {
    this.router.navigate(['menu']);
  }
}
