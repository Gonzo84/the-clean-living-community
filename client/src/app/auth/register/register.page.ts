import {Component} from '@angular/core';
import {Router} from '@angular/router';
import {AuthService} from '../auth.service';

@Component({
    selector: 'app-register',
    templateUrl: './register.page.html',
    styleUrls: ['./register.page.scss'],
})
export class RegisterPage {
    toggleStatus;

    constructor(private  authService: AuthService, private  router: Router) {
    }

    register(form) {
        const type = this.toggleStatus ? 'mentor' : 'friend';
        form.value.type = type;
        this.authService.register(form.value).subscribe((res) => {
            this.router.navigateByUrl('login');
        });
    }

}
