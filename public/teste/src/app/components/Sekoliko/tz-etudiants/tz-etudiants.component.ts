import {Component, OnInit, ViewChildren, QueryList, ElementRef} from '@angular/core';
import {HttpClient} from '@angular/common/http';

@Component({
    selector: 'app-tz-etudiants',
    templateUrl: './tz-etudiants.component.html',
    styleUrls: ['./tz-etudiants.component.scss']
})
export class TzEtudiantsComponent implements OnInit {

    @ViewChildren('list') list: QueryList<ElementRef>;
    url: any = 'https://reqres.in/api/products?per_page=12';
    niveau = [];

    details = 'Cliquer pour voir details';

    constructor(private http: HttpClient) {
    }

    getNiveau() {
        return this.http.get(this.url);
    }

    ngOnInit() {
        this.getNiveau().subscribe((data: any) => {
            data.data.forEach((element: any) => {
                this.niveau.push({
                    id: (element.id).toString(),
                    name: element.name,
                    color: element.color
                });
                console.log(this.niveau);
            });
            // this.userList = data;
            // console.log(data);
        });
    }

}
