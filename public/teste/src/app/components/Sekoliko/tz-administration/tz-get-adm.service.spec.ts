import { TestBed, inject } from '@angular/core/testing';

import { TzGetAdmService } from './tz-get-adm.service';

describe('TzGetAdmService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [TzGetAdmService]
    });
  });

  it('should be created', inject([TzGetAdmService], (service: TzGetAdmService) => {
    expect(service).toBeTruthy();
  }));
});
