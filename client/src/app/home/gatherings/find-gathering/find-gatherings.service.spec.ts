import { TestBed } from '@angular/core/testing';

import { FindGatheringsService } from './find-gatherings.service';

describe('FindGatheringsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: FindGatheringsService = TestBed.get(FindGatheringsService);
    expect(service).toBeTruthy();
  });
});
