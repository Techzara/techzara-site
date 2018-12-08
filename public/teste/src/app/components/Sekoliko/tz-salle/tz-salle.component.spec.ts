import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzSalleComponent } from './tz-salle.component';

describe('TzSalleComponent', () => {
  let component: TzSalleComponent;
  let fixture: ComponentFixture<TzSalleComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzSalleComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzSalleComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
