import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ClassRoutingModule } from './class-routing.module';
import {ClassComponent} from './class.component';
import { ListClassComponent } from './list-class/list-class.component';

@NgModule({
  imports: [
    CommonModule,
    ClassRoutingModule
  ],
  declarations: [ClassComponent, ListClassComponent]
})
export class ClassModule { }
