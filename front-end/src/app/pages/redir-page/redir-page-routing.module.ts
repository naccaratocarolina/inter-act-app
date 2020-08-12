import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { RedirPagePage } from './redir-page.page';

const routes: Routes = [
  {
    path: '',
    component: RedirPagePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class RedirPagePageRoutingModule {}
