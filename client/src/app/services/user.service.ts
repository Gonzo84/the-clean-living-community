import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Storage} from '@ionic/storage';
import {UserInterface} from '../interfaces/user';

@Injectable({
    providedIn: 'root'
})
export class UserService {

    constructor(private http: HttpClient,
                private storage: Storage) {
    }

    public getLoggedUser() {
        return this.storage.get('LOGGED_USER');
    }

    public getSurveyQuestions() {
        return this.storage.get('SURVEY_QUESTIONS');
    }

    public removeLoggedUser() {
        return this.storage.remove('LOGGED_USER');
    }

    public removeSurveyQuestions() {
        return this.storage.remove('SURVEY_QUESTIONS');
    }

    public setLoggedUser(user: UserInterface) {
        return this.storage.set('LOGGED_USER', user);
    }

    public setSueveyQuestions(questions) {
        this.storage.set('SURVEY_QUESTIONS', questions);
    }
}
