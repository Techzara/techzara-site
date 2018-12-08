import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {ListClassComponent} from './list-class/list-class.component';
import {ClassComponent} from './class.component';

const routes: Routes = [
  {
    path: '',
    component: ClassComponent,
    children: [
      {path: '', redirectTo: 'list-etudiant'},
      {path: 'list-class', component: ListClassComponent},
      { path: '**', redirectTo: 'list-etudiant' }
    ]
  }
];


@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ClassRoutingModule { }
