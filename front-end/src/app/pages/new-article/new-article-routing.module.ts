import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { NewArticlePage } from './new-article.page';

const routes: Routes = [
  {
    path: '',
    component: NewArticlePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class NewArticlePageRoutingModule {}
