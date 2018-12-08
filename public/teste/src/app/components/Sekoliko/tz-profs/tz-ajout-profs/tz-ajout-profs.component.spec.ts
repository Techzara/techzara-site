import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzAjoutProfsComponent } from './tz-ajout-profs.component';

describe('TzAjoutProfsComponent', () => {
  let component: TzAjoutProfsComponent;
  let fixture: ComponentFixture<TzAjoutProfsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzAjoutProfsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzAjoutProfsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
