import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { ManagePlataformPage } from './manage-plataform.page';

const routes: Routes = [
  {
    path: '',
    component: ManagePlataformPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class ManagePlataformPageRoutingModule {}
