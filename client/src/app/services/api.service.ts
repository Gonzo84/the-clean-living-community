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

    public getSurveyQuestions(): Observable<any> {
        return this.http.get('./assets/survey/survey.json');
    }

    public getUserInfo(id: number): Observable<any> {
        return this.http.get(`${ENV.SERVER_ADDRESS}/users/${id}`);
    }

    public resetPassword(email): Observable<any> {
        return this.http.post(`${ENV.SERVER_ADDRESS}/users/password/reset`, email);
    }
}
