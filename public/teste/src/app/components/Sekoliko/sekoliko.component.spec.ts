import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SekolikoComponent } from './sekoliko.component';

describe('SekolikoComponent', () => {
  let component: SekolikoComponent;
  let fixture: ComponentFixture<SekolikoComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SekolikoComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SekolikoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
