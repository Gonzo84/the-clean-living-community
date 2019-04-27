import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import ENV from '../../ENV';
import {Observable} from 'rxjs';

@Injectable({
    providedIn: 'root'
})
export class ApiService {

    constructor(private http: HttpClient) {
    }

    public completeProfile(profile, id) {
        return this.http.post(`${ENV.SERVER_ADDRESS}/users/${id}/data`, profile);
    }

    public getSurveyQuestions(id: number): Observable<any> {
        const params = {
            survey: 1,
            user: id
        };
        return this.http.post(`${ENV.SERVER_ADDRESS}/survey/all`, params);
    }

    public getUserInfo(id: number): Observable<any> {
        return this.http.get(`${ENV.SERVER_ADDRESS}/users/${id}`);
    }

    public resetPassword(email: any): Observable<any> {
        return this.http.post(`${ENV.SERVER_ADDRESS}/users/password/reset`, email);
    }
}
