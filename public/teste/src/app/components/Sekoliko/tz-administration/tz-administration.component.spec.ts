import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzAdministrationComponent } from './tz-administration.component';

describe('TzAdministrationComponent', () => {
  let component: TzAdministrationComponent;
  let fixture: ComponentFixture<TzAdministrationComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzAdministrationComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzAdministrationComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
