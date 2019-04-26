import {Injectable, Injector} from '@angular/core';
import {
    HttpRequest,
    HttpHandler,
    HttpEvent,
    HttpInterceptor,
    HttpHeaders, HttpErrorResponse, HttpResponse
} from '@angular/common/http';

import {Observable} from 'rxjs/Observable';
import 'rxjs/add/observable/fromPromise';
import 'rxjs/add/operator/mergeMap';
import 'rxjs/add/observable/of';
import {throwError} from 'rxjs';
import {map, catchError} from 'rxjs/operators';

import {TokenService} from '../services/token.service';
import {ToastController} from '@ionic/angular';

@Injectable()
export class TokenInterceptor implements HttpInterceptor {

    constructor(private injector: Injector,
                private toastCtrl: ToastController) {
    }

    private authorizationObservableMergeMap(request: HttpRequest<any>, next: HttpHandler, headers: HttpHeaders, authBearer: string): Observable<HttpEvent<any>> {
        request = request.clone({
            setHeaders: {
                Authorization: `Bearer ${authBearer}`
            }
        });
        return next.handle(request);
    }

    public getAuthorizationBearer() {
        const tokenService = this.injector.get(TokenService);
        return tokenService.getAccessToken();
    }

    public intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        let observable;
        if (this.requestNeedsToBeIntercepted(request)) {
            observable = this.setAuthorizationHeader(request, next);
        } else {
            observable = next.handle(request);
        }


        return observable.pipe(
            catchError((error: HttpErrorResponse) => {
                let msg = '';
                switch (error.status) {
                    case 401:
                        msg = this.generateErrorMsg(error);
                        this.presentToast(msg);
                        break;
                    case 403:
                        msg = this.generateErrorMsg(error);
                        this.presentToast(msg);
                        break;
                    case 422:
                        msg = this.generateErrorMsg(error);
                        this.presentToast(msg);
                        break;
                    default:
                        this.presentToast('Something went wrong!');
                        break;
                }
                return throwError(error);
            }));
    }

    private generateErrorMsg(error: HttpErrorResponse) {
        const errorObj = error.error.error;
        let msg = '';
        if (typeof errorObj === 'string') {
            msg = errorObj;
        } else {
            msg = errorObj[Object.keys(errorObj)[0]][0];
        }
        return msg;
    }

    private async presentToast(msg) {
        const toast = await this.toastCtrl.create({
            message: msg,
            duration: 2000,
            position: 'bottom'
        });
        toast.present();
    }

    private requestNeedsToBeIntercepted(request: HttpRequest<any>) {
        const needsIntercepting = (request.method !== 'POST' && !request.url.includes('/users')) && !request.url.includes('users/login');
        return needsIntercepting;
    }

    private setAuthorizationHeader(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        const authorizationObservable = Observable.fromPromise(this.getAuthorizationBearer());
        return authorizationObservable.mergeMap(this.authorizationObservableMergeMap.bind(this, request, next));
    }
}
