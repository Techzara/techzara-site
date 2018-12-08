import {Component, OnInit, ViewChildren, QueryList, ElementRef} from '@angular/core';
import {HttpClient} from '@angular/common/http';

@Component({
    selector: 'app-tz-administration',
    templateUrl: './tz-administration.component.html',
    styleUrls: ['./tz-administration.component.scss']
})

export class TzAdministrationComponent implements OnInit {

    @ViewChildren('list') list: QueryList<ElementRef>;
    url: any = 'https://reqres.in/api/users?per_page=8';
    userList = [];

    constructor(private http: HttpClient) {
    }

    // constructor(private getadm: TzGetAdmService) {
    // }

    getData() {
        return this.http.get(this.url);
    }

    ngOnInit() {
        // this.getadm.fetchUser();
        this.getData().subscribe((data: any) => {
            data.data.forEach((element: any) => {
                this.userList.push({
                    id: (element.id).toString(),
                    name: element.last_name,
                    email: element.first_name,
                    photo: element.avatar
                });
                console.log(this.userList);
            });
            // this.userList = data;
            // console.log(data);
        });
    }

}
