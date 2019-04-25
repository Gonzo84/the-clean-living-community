import {Injectable} from '@angular/core';
import {Storage} from "@ionic/storage";

@Injectable({
    providedIn: 'root'
})
export class TokenService {

    constructor(private storage: Storage) {
    }

    public setAccessToken(token: string) {
        return this.storage.set('ACCESS_TOKEN', token);
    }

    public getAccessToken() {
        return this.storage.get('ACCESS_TOKEN');
    }

    public removeAccessToken() {
        return this.storage.remove('ACCESS_TOKEN');
    }
}
