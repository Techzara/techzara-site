import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzAdmDetailsComponent } from './tz-adm-details.component';

describe('TzAdmDetailsComponent', () => {
  let component: TzAdmDetailsComponent;
  let fixture: ComponentFixture<TzAdmDetailsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzAdmDetailsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzAdmDetailsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
