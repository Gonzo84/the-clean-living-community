import {Component, OnInit} from '@angular/core';
import {Router} from '@angular/router';
import ENV from '../../../../ENV';
import {HttpClient} from '@angular/common/http';

@Component({
    selector: 'app-find-gathering',
    templateUrl: './find-gathering.component.html',
    styleUrls: ['./find-gathering.component.scss'],
})
export class FindGatheringComponent implements OnInit {

    searchTerm: any = '';
    gatherings: any;
    filteredGatherings: any = [];

    constructor(public router: Router, private http: HttpClient) {
        this.getGatheringList().subscribe(this.updateGatheringList.bind(this));
    }

    updateGatheringList(response) {
        // noinspection TypeScriptUnresolvedVariable
        this.gatherings = this.filteredGatherings = response.data;
    }

    getGatheringList() {
        return this.http.post(`${ENV.SERVER_ADDRESS}/gathering/all`, {});
    }

    filterItems(searchTerm) {
        let gatherings = [];

        if (this.gatherings) {
            gatherings = JSON.parse(JSON.stringify(this.gatherings));
            if (searchTerm && searchTerm.length) {
                gatherings = gatherings.filter((gathering) => {
                    return searchTerm && gathering.title.toLowerCase().startsWith(searchTerm.toLowerCase());
                });
            }
        }
        return gatherings;
    }

    ngOnInit() {
    }

    setFilteredItems(ev) {
        if (ev) {
            this.searchTerm = ev.target.value;
        }
        this.filteredGatherings = this.filterItems(this.searchTerm);
    }

    viewGathering(gathering) {
        // noinspection JSIgnoredPromiseFromCall
        this.router.navigateByUrl('/home/gatherings/view/' + gathering.id);
    }
}
