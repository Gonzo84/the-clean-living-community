import {Component, OnInit, ViewChild} from '@angular/core';
import {ApiService} from '../services/api.service';

@Component({
    selector: 'page-survey',
    templateUrl: 'survey.html',
})
export class SurveyPage implements OnInit {

    public answers: any = [{
        answer: 'Strongly Disagree',
        value: -2
    }, {
        answer: 'Disagree',
        value: -1
    }, {
        answer: 'Neutral',
        value: -0
    }, {
        answer: 'Agree',
        value: 1
    }, {
        answer: 'Strongly Agree',
        value: 2
    }];

    @ViewChild('slides') slides: any;

    @ViewChild('slidesByCategory') slidesByCategory: any;

    hasAnswered = false;
    questions: any;
    categories: any[];


    constructor(private api: ApiService) {
    }

    public ngOnInit() {
        this.api.getSurveyQuestions().subscribe(this.loadData.bind(this))
    }

    ionViewDidLoad() {
        this.slidesByCategory.lockSwipes(true);
    }

    private loadData(data) {
        this.categories = data.questions;
    }

    finishSurvey() {

    }

    nextCategory() {
        this.slidesByCategory.lockSwipes(false);
        this.slidesByCategory.slideNext();
        this.slidesByCategory.lockSwipes(true);
    }

    nextSlide() {
        this.slides.lockSwipes(false);
        this.slides.slideNext();
        this.slides.lockSwipes(true);
    }

    selectAnswer(value, index) {
        this.hasAnswered = true;
        setTimeout(() => {
            this.hasAnswered = false;
            if (index === 4) {
                this.nextCategory();
            } else {
                this.nextSlide();
            }
        }, 1000);
    }
}
