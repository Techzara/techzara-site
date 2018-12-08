import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzPayementsComponent } from './tz-payements.component';

describe('TzPayementsComponent', () => {
  let component: TzPayementsComponent;
  let fixture: ComponentFixture<TzPayementsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzPayementsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzPayementsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
