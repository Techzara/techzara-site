import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { TzListProfsComponent } from './tz-list-profs.component';

describe('TzListProfsComponent', () => {
  let component: TzListProfsComponent;
  let fixture: ComponentFixture<TzListProfsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ TzListProfsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(TzListProfsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
