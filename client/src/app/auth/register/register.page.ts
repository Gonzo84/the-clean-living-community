import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../auth.service';

@Component({
    selector: 'app-register',
    templateUrl: './register.page.html',
    styleUrls: ['./register.page.scss'],
})
export class RegisterPage {

    constructor(private  authService: AuthService, private  router: Router) {
    }

    register(form) {
        this.authService.register(form.value).subscribe((res) => {
            this.router.navigateByUrl('login');
        });
    }

}
