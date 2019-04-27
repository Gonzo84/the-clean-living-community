import {Component, OnInit, ViewChild} from '@angular/core';
import {ApiService} from '../services/api.service';
import {UserService} from '../services/user.service';
import {Router} from '@angular/router';

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
                private userSerice: UserService,
                private router: Router) {
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
        this.api.finishSurvey(this.loggedUser.id)
            .subscribe(
                this.onFinishSurveySuccess.bind(this),
                this.onFinishSurveyFailure.bind(this)
            );

    }

    private nextSlide() {
        this.slides.lockSwipes(false);
        this.slides.slideNext();
        this.slides.lockSwipes(true);
    }

    private selectAnswer(answer, value) {
        this.hasAnswered = true;
        this.api.submitSurveyQuestion(this.loggedUser.id, answer.id, value)
            .subscribe(this.onSubmitQuestionSuccess.bind(this),
                this.onSubmitQuestionFailure.bind(this));
    }

    private async onGetUserInfoSuccess(user) {
        await this.userSerice.setLoggedUser(user.data);
        this.router.navigateByUrl('home/search');

    }

    private async onGetUserInfoFailure() {
        console.log('onGetUserInfoFailure');
    }

    private onFinishSurveySuccess() {
        this.api.getUserInfo(this.loggedUser.id).subscribe(this.onGetUserInfoSuccess.bind(this));
    }

    private onFinishSurveyFailure() {
        console.log('onFinishSurveyFailure');
    }

    private onSubmitQuestionSuccess(data) {
        setTimeout(() => {
            this.hasAnswered = false;
            this.nextSlide();
        }, 500);
    }

    private onSubmitQuestionFailure() {
        console.log('onSubmitQuestionFailure');
    }
}
