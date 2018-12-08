import {ElementRef, Injectable, QueryList, ViewChildren} from '@angular/core';
import {HttpClient} from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class TzGetAdmService {
    @ViewChildren('list') list: QueryList<ElementRef>;
    url: any = 'https://reqres.in/api/users?per_page=8';
    userList = [];

    getData() {
        return this.http.get(this.url);
    }

    constructor(private http: HttpClient) {

    }

    fetchUser() {
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
