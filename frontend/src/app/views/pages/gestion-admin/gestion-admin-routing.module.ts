import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ListeUsersComponent } from './users/liste-users/liste-users.component';

const routes: Routes = [
  //declaration des routes ici amin
  {path: '' , component : ListeUsersComponent},
  {path: 'users' , component : ListeUsersComponent},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class GestionAdminRoutingModule { }
