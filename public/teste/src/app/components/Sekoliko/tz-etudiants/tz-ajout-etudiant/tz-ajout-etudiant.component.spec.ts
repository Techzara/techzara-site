import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzAjoutEtudiantComponent } from './tz-ajout-etudiant.component';

describe('TzAjoutEtudiantComponent', () => {
  let component: TzAjoutEtudiantComponent;
  let fixture: ComponentFixture<TzAjoutEtudiantComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzAjoutEtudiantComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzAjoutEtudiantComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
