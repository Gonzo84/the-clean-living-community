import {Component, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {HttpClient} from '@angular/common/http';
import {AuthService} from '../../../auth/auth.service';

@Component({
    selector: 'app-view-gathering',
    templateUrl: './view-gathering.component.html',
    styleUrls: ['./view-gathering.component.scss'],
})
export class ViewGatheringComponent implements OnInit {
    gathering: any = {};

    constructor(private activatedRoute: ActivatedRoute, private http: HttpClient, private auth: AuthService) {

        const id = this.activatedRoute.snapshot.paramMap.get('id');
        this.http.get(`${auth.AUTH_SERVER_ADDRESS}/gathering/${id}`, {}).subscribe(this.updateGathering.bind(this));
    }

    updateGathering(response) {
        this.gathering = response.data;
    }

    ngOnInit() {
    }

}
