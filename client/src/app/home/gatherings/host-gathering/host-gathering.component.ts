import {Component, OnInit} from '@angular/core';
import {Validators, FormBuilder, FormGroup, FormControl} from '@angular/forms';
import {HttpClient} from '@angular/common/http';
import {Router} from '@angular/router';
import ENV from '../../../../ENV';

@Component({
    selector: 'app-host-gathering',
    templateUrl: './host-gathering.component.html',
    styleUrls: ['./host-gathering.component.scss'],
})
export class HostGatheringComponent implements OnInit {
    private gathering: FormGroup;

    constructor(private formBuilder: FormBuilder, private http: HttpClient, private router: Router) {
        this.gathering = this.formBuilder.group({
            title: new FormControl('', Validators.required),
            description: new FormControl('', Validators.required),
            city: new FormControl('', Validators.required),
            street: new FormControl('', Validators.required),
            number: new FormControl('', Validators.required),
            creator: '',
            time: new FormControl('', Validators.required)
        });
    }

    ngOnInit() {
    }

    createGathering() {
        const data = {
            title: this.gathering.get('title').value,
            description: this.gathering.get('description').value,
            city: this.gathering.get('city').value,
            street: this.gathering.get('street').value,
            number: this.gathering.get('number').value,
            time: new Date(this.gathering.get('time').value).getTime(),
        };

        this.http.post(`${ENV.SERVER_ADDRESS}/gathering`, data).subscribe((response: any) => {
            this.router.navigateByUrl('/home/gatherings/view/' + response.data.id);
        });
    }
}
