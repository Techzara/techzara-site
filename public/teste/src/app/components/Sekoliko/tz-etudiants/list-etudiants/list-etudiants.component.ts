import {Component, OnInit, HostListener, ViewChildren, QueryList, ElementRef} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {urlList} from "../../../../Utils/api/urlList";

@Component({
    selector: 'app-list-etudiants',
    templateUrl: './list-etudiants.component.html',
    styleUrls: ['./list-etudiants.component.scss']
})
export class ListEtudiantsComponent implements OnInit {
    @ViewChildren('list') list: QueryList<ElementRef>;
    paginators: Array<any> = [];
    activePage: number = 1;
    firstVisibleIndex: number = 1;
    lastVisibleIndex: number = 10;
    per_page: string = '?per_page=' + 30;
    url: any = urlList.path_teste_user;
    tableData = [];
    sorted = false;
    searchText: string;
    firstPageNumber: number = 1;
    lastPageNumber: number;
    maxVisibleItems: number = 5;

    constructor(private http: HttpClient) {
    }

    getData() {
        console.log(this.url);
        return this.http.get(this.url);
    }

    ngOnInit() {
        this.getData().subscribe((next: any) => {
            next.forEach((element: any) => {
                console.log(element);
                this.tableData.push({id: (element.id).toString(), name: element.name, email: element.email});
            });
        });

        setTimeout(() => {
            for (let i = 1; i <= this.tableData.length; i++) {
                if (i % this.maxVisibleItems === 0) {
                    this.paginators.push(i / this.maxVisibleItems);
                }
            }
            if (this.tableData.length % this.paginators.length !== 0) {
                this.paginators.push(this.paginators.length + 1);
            }
            this.lastPageNumber = this.paginators.length;
            this.lastVisibleIndex = this.maxVisibleItems;
        }, 200);

    }

    @HostListener('input') oninput() {
        this.paginators = [];
        for (let i = 1; i <= this.search().length; i++) {
            if (!(this.paginators.indexOf(Math.ceil(i / this.maxVisibleItems)) !== -1)) {
                this.paginators.push(Math.ceil(i / this.maxVisibleItems));
            }
        }
        this.lastPageNumber = this.paginators.length;
    }

    changePage(event: any) {
        if (event.target.text >= 1 && event.target.text <= this.maxVisibleItems) {
            this.activePage = +event.target.text;
            this.firstVisibleIndex = this.activePage * this.maxVisibleItems - this.maxVisibleItems + 1;
            this.lastVisibleIndex = this.activePage * this.maxVisibleItems;
        }
    }

    nextPage() {
        this.activePage += 1;
        this.firstVisibleIndex = this.activePage * this.maxVisibleItems - this.maxVisibleItems + 1;
        this.lastVisibleIndex = this.activePage * this.maxVisibleItems;
    }

    previousPage() {
        this.activePage -= 1;
        this.firstVisibleIndex = this.activePage * this.maxVisibleItems - this.maxVisibleItems + 1;
        this.lastVisibleIndex = this.activePage * this.maxVisibleItems;
    }

    firstPage() {
        this.activePage = 1;
        this.firstVisibleIndex = this.activePage * this.maxVisibleItems - this.maxVisibleItems + 1;
        this.lastVisibleIndex = this.activePage * this.maxVisibleItems;
    }

    lastPage() {
        this.activePage = this.lastPageNumber;
        this.firstVisibleIndex = this.activePage * this.maxVisibleItems - this.maxVisibleItems + 1;
        this.lastVisibleIndex = this.activePage * this.maxVisibleItems;
    }

    sortBy(by: string | any): void {
        if (by == 'id') {
            this.search().reverse();
        } else {
            this.search().sort((a: any, b: any) => {
                if (a[by] < b[by]) {
                    return this.sorted ? 1 : -1;
                }
                if (a[by] > b[by]) {
                    return this.sorted ? -1 : 1;
                }
                return 0;
            });
        }
        this.sorted = !this.sorted;
    }

    filterIt(arr: any, searchKey: any) {
        return arr.filter((obj: any) => {
            return Object.keys(obj).some((key) => {
                return obj[key].includes(searchKey);
            });
        });
    }

    search() {
        if (!this.searchText) {
            return this.tableData;
        }
        if (this.searchText) {
            return this.filterIt(this.tableData, this.searchText);
        }
    }
}
