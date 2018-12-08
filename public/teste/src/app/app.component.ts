import {Component, OnInit} from '@angular/core';
import {Constants} from './Utils/Constants';
import {Router} from '@angular/router';
import {AuthentificationService} from './shared/service/authentification.service';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent implements OnInit {
  title = Constants.TITLE;
  public location = '' ;
  constructor(private  _router: Router, private auth: AuthentificationService) {
  }
  ngOnInit() {
    this.location =  localStorage.getItem('token');
    console.log(this.location);
  }

}
