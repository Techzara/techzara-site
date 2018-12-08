import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzEtudiantsComponent } from './tz-etudiants.component';

describe('TzEtudiantsComponent', () => {
  let component: TzEtudiantsComponent;
  let fixture: ComponentFixture<TzEtudiantsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzEtudiantsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzEtudiantsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
