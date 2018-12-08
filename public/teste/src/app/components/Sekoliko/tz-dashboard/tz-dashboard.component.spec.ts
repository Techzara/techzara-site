import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzDashboardComponent } from './tz-dashboard.component';

describe('TzDashboardComponent', () => {
  let component: TzDashboardComponent;
  let fixture: ComponentFixture<TzDashboardComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzDashboardComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzDashboardComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
