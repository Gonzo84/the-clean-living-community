import {Injectable} from '@angular/core';
import 'rxjs/add/operator/map';
import {HttpClient} from '@angular/common/http';
import ENV from '../../../../ENV';


@Injectable({
    providedIn: 'root'
})
export class FindGatheringsService {

    gatherings: any = [];

    constructor(private http: HttpClient) {
        this.http.post(`${ENV.SERVER_ADDRESS}/gathering/all`, {}).subscribe(this.updateGatheringList.bind(this));
    }

    updateGatheringList(response) {
        // noinspection TypeScriptUnresolvedVariable
        this.gatherings = response.data;
    }

    filterItems(searchTerm) {
        return this.gatherings.filter((gathering) => {
            return searchTerm && gathering.title.toLowerCase().startsWith(searchTerm.toLowerCase());
        });
    }
}
