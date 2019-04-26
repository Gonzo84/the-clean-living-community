import {Component, OnInit, ViewChild} from '@angular/core';
import {ApiService} from '../services/api.service';

@Component({
    selector: 'page-survey',
    templateUrl: 'survey.html',
    styleUrls: ['./survey.scss'],
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
        this.api.getSurveyQuestions()
            .subscribe(this.loadData.bind(this));
    }

    public ionViewDidEnter() {
        // this.slides.lockSwipes(true);
        this.slidesByCategory.lockSwipes(true);
    }

    private loadData(data) {
        this.categories = data.questions;
    }

    private finishSurvey() {

    }

    private nextSlide(slides) {
        slides.lockSwipes(false);
        slides.slideNext();
        slides.lockSwipes(true);
    }

    private selectAnswer(value, index) {
        this.hasAnswered = true;
        setTimeout(() => {
            this.hasAnswered = false;
            const slides = index < 4 ? this.slides : this.slidesByCategory;
            this.nextSlide(slides);
        }, 1000);
    }

    test() {
        this.nextSlide(this.slidesByCategory);
    }
}
