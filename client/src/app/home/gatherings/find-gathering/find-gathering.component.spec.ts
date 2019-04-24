import {CUSTOM_ELEMENTS_SCHEMA} from '@angular/core';
import {async, ComponentFixture, TestBed} from '@angular/core/testing';

import {FindGatheringComponent} from './find-gathering.component';

describe('FindGatheringComponent', () => {
    let component: FindGatheringComponent;
    let fixture: ComponentFixture<FindGatheringComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            declarations: [FindGatheringComponent],
            schemas: [CUSTOM_ELEMENTS_SCHEMA],
        })
            .compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(FindGatheringComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
