import {Component, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {ApiService} from '../../../services/api.service';
import {IonInfiniteScroll} from '@ionic/angular';
import {Router} from '@angular/router';

@Component({
    selector: 'app-find-connection',
    templateUrl: './find-connection.component.html',
    styleUrls: ['./find-connection.component.scss'],
})
export class FindConnectionComponent implements OnInit {

    @ViewChild(IonInfiniteScroll) infiniteScroll: IonInfiniteScroll;

    type: any = 'friend';
    searchTerm: any = '';
    connections: any = [];

    data: any;
    errorMessage: string;
    timeId: number;
    page = 1;
    perPage = 0;
    totalData = 0;
    totalPage = 0;

    constructor(
        private activatedRoute: ActivatedRoute,
        private api: ApiService,
        private router: Router) {

        this.type = this.activatedRoute.snapshot.paramMap.get('type');
        this.getUsers(this.type, '', 1);
    }

    getUsers(type, name, page) {
        this.api.filterUsers(type, name, page)
            .subscribe(this.setListData.bind(this),
                error => this.errorMessage = <any>error
            );
    }

    setListData(res) {
        this.data = res.data;
        this.perPage = this.data.per_page;
        this.totalData = this.data.total;
        this.totalPage = this.data.last_page;

        if (this.page > 1) {
            this.connections = this.connections.concat(this.data.data);
        } else {
            this.connections = this.data.data;
        }
    }

    doInfinite(event) {
        this.page++;
        setTimeout(function () {
            this.getUsers(this.type, this.searchTerm, this.page);
            event.target.complete();
        }.bind(this), 200);
    }

    ngOnInit() {
    }

    setFilteredItems() {
        if (this.timeId) {
            clearTimeout(this.timeId);
        }

        this.timeId = setTimeout(function () {
            this.page = 1;
            this.getUsers(this.type, this.searchTerm, 1);
        }.bind(this), 400);
    }

    generateAvatar(name) {
        let firstInitial = '';
        let lastInitial = '';
        const names = name.split(' ');
        const firstName = names[0];
        let lastName;

        if (names[1]) {
            lastName = names[1];
        }

        if (firstName.length) {
            firstInitial = firstName[0];
        }
        if (lastName && lastName.length) {
            lastInitial = lastName[0];
        }

        return firstInitial + lastInitial;
    }

    viewProfile(id: any) {
        this.router.navigateByUrl('/home/my-profile/' + id);
    }
}
