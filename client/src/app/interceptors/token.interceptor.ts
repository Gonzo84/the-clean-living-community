import {Injectable, Injector} from '@angular/core';
import {
    HttpRequest,
    HttpHandler,
    HttpEvent,
    HttpInterceptor,
    HttpHeaders
} from '@angular/common/http';

import {Observable} from 'rxjs/Observable';
import 'rxjs/add/observable/fromPromise';
import 'rxjs/add/operator/mergeMap';

import {TokenService} from "../services/token.service";

@Injectable()
export class TokenInterceptor implements HttpInterceptor {

    constructor(private injector: Injector) {
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

    intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        let observable;
        if (this.requestNeedsToBeIntercepted(request)) {
            observable = this.setAuthorizationHeader(request, next);
        } else {
            observable = next.handle(request);
        }

        return observable;
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
