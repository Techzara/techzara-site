import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzClasseComponent } from './tz-classe.component';

describe('TzClasseComponent', () => {
  let component: TzClasseComponent;
  let fixture: ComponentFixture<TzClasseComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzClasseComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzClasseComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
