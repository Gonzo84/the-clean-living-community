import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';

@Injectable({
    providedIn: 'root'
})
export class ApiService {

    constructor(private http: HttpClient) {
    }

    public getSurveyQuestions() {
        return this.http.get('./assets/survey/survey.json');
    }
}
