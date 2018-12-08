import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzProfsComponent } from './tz-profs.component';

describe('TzProfsComponent', () => {
  let component: TzProfsComponent;
  let fixture: ComponentFixture<TzProfsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzProfsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzProfsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
