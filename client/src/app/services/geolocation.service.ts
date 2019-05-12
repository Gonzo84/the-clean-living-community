import {Injectable} from '@angular/core';
import {Coordinates, Geolocation, GeolocationOptions} from '@ionic-native/geolocation/ngx';
import {Subscription} from 'rxjs';
import {ApiService} from './api.service';
import {UserService} from './user.service';

@Injectable()
export class GeolocationService {

    private location: any = undefined;

    private watchSubscription: Subscription;

    private interval;

    private second = 1000;

    private minute = 60 * this.second;

    private loggedUser;

    constructor(private geolocation: Geolocation,
                private api: ApiService,
                private userService: UserService) {
    }

    public getLocation(): Coordinates {
        return this.location;
    }

    private getLoggedUser(user): void {
        this.loggedUser = user;
        this.interval = setInterval(this.sendLocation.bind(this), 20 * this.minute);
    }

    private getOptions(): GeolocationOptions {
        return {
            enableHighAccuracy: true,
            timeout: 5000
        };
    }

    private logError(error): void {
        console.log(error);
    }

    private sendLocation(): void {
        if (this.location) {
            this.api.location(this.loggedUser.id, this.location.longitude, this.location.latitude).subscribe();
        }
    }

    public stopWatchLocation(): void {
        this.watchSubscription.unsubscribe();
        this.loggedUser = undefined;
        clearInterval(this.interval);
    }

    private updateLocation(location: any): void {
        if (location.coords) {
            this.location = location.coords;
        }
    }

    public watchLocation() {
        this.watchSubscription = this.geolocation.watchPosition(this.getOptions())
            .subscribe(this.updateLocation.bind(this));

        this.userService.getLoggedUser()
            .then(this.getLoggedUser.bind(this))
            .catch(this.logError.bind(this));
    }

}
