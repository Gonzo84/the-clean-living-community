import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {HttpClient} from '@angular/common/http';
import ENV from '../../../../ENV';

@Component({
    selector: 'app-view-gathering',
    templateUrl: './view-gathering.component.html',
    styleUrls: ['./view-gathering.component.scss'],
})
export class ViewGatheringComponent implements OnInit {
    gathering: any = {};

    constructor(private activatedRoute: ActivatedRoute, private http: HttpClient) {

        const id = this.activatedRoute.snapshot.paramMap.get('id');
        this.http.get(`${ENV.SERVER_ADDRESS}/gathering/${id}`, {}).subscribe(this.updateGathering.bind(this));
    }

    updateGathering(response) {
        this.gathering = response.data;
    }

    ngOnInit() {
    }

}
