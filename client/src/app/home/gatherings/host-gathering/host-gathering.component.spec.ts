import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { HostGatheringComponent } from './host-gathering.component';

describe('HostGatheringComponent', () => {
  let component: HostGatheringComponent;
  let fixture: ComponentFixture<HostGatheringComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ HostGatheringComponent ],
      schemas: [CUSTOM_ELEMENTS_SCHEMA],
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(HostGatheringComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
