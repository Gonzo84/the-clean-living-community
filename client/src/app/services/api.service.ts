import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import ENV from '../../ENV';

@Injectable({
    providedIn: 'root'
})
export class ApiService {

    constructor(private http: HttpClient) {
    }

    public completeProfile(profile, id) {
        return this.http.post(`${ENV.SERVER_ADDRESS}/users/${id}/data`, profile);
    }

    public getSurveyQuestions() {
        return this.http.get('./assets/survey/survey.json');
    }

    public resetPassword(email) {
        return this.http.post(`${ENV.SERVER_ADDRESS}/users/password/reset`, email);
    }
}
