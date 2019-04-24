import {Component, OnInit} from '@angular/core';
import {FindGatheringsService} from './find-gatherings.service';
import {Router} from '@angular/router';

@Component({
    selector: 'app-find-gathering',
    templateUrl: './find-gathering.component.html',
    styleUrls: ['./find-gathering.component.scss'],
})
export class FindGatheringComponent implements OnInit {

    searchTerm: any = '';
    gatherings: any;

    constructor(public findGathering: FindGatheringsService, public router: Router) {
    }

    ngOnInit() {
        this.setFilteredItems(undefined);
    }

    setFilteredItems(ev) {
        if (ev) {
            this.searchTerm = ev.target.value;
        }
        this.gatherings = this.findGathering.filterItems(this.searchTerm);
    }

    viewGathering(gathering) {
        this.router.navigateByUrl('/home/gatherings/view/' + gathering.id);
    }
}
