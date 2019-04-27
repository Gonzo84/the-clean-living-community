import {Component, OnInit, ViewChild} from '@angular/core';
import {ApiService} from '../services/api.service';
import {UserService} from '../services/user.service';

@Component({
    selector: 'page-survey',
    templateUrl: 'survey.html',
    styleUrls: ['./survey.scss'],
})
export class SurveyPage implements OnInit {
    loggedUser;
    @ViewChild('slides') slides: any;

    hasAnswered = false;
    questions: any;


    constructor(private api: ApiService,
                private userSerice: UserService) {
    }

    public async ngOnInit() {
        this.loggedUser = await this.userSerice.getLoggedUser();
        this.api.getSurveyQuestions(this.loggedUser.id)
            .subscribe(this.loadData.bind(this));
    }

    public ionViewDidEnter() {
        this.slides.lockSwipes(true);
    }

    private loadData(data) {
        this.questions = data.data.survey_score;
    }

    private finishSurvey() {

    }

    private nextSlide() {
        this.slides.lockSwipes(false);
        this.slides.slideNext();
        this.slides.lockSwipes(true);
    }

    private selectAnswer(answer) {
        this.hasAnswered = true;
        setTimeout(() => {
            this.hasAnswered = false;
            this.nextSlide();
        }, 1000);
    }
}
