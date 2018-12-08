import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';

const routes: Routes = [
    {path: '', redirectTo: 'login', pathMatch: 'full'},
    {path: 'login', loadChildren: 'src/app/components/login/login.module#LoginModule'},
    {path: 'menu', loadChildren: 'src/app/components/Sekoliko/sekoliko.module#SekolikoModule'},
    {path: '**', redirectTo: 'login'}
];


@NgModule({
    imports: [
        RouterModule.forRoot(routes)
    ],
    exports: [RouterModule],
    declarations: []
})
export class AppRoutingModule {
}
