import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Storage} from "@ionic/storage";
import {UserInterface} from "../interfaces/user";

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

    public removeLoggedUser() {
        return this.storage.remove('LOGGED_USER');
    }

    public setLoggedUser(user: UserInterface) {
        return this.storage.set('LOGGED_USER', user);
    }
}
