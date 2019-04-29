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

    public getUnansweredQuestions(id: number): Observable<any> {
        const params = {
            survey: 1,
            user: id
        };
        return this.http.post(`${ENV.SERVER_ADDRESS}/survey/all`, params);
    }

    public getUserInfo(id: number): Observable<any> {
        return this.http.get(`${ENV.SERVER_ADDRESS}/users/${id}`);
    }

    public filterUsers(type, name, page) {
        const params = {
            type,
            name,
            page
        };
        // @ts-ignore
        return this.http.get(`${ENV.SERVER_ADDRESS}/users?name=${name}&type=${type}&page=${page}`, params);
    }

    public finishSurvey(userId) {
        const params = {
            survey: 1,
            user: userId
        };
        return this.http.post(`${ENV.SERVER_ADDRESS}/survey/finish`, params);
    }

    public resetPassword(email: any): Observable<any> {
        return this.http.post(`${ENV.SERVER_ADDRESS}/users/password/reset`, email);
    }

    public submitSurveyQuestion(userId, questionId, answer) {
        const params = {
            user_id: userId,
            question_id: questionId,
            answer: answer
        };
        return this.http.post(`${ENV.SERVER_ADDRESS}/survey/categories/question`, params);
    }
}
