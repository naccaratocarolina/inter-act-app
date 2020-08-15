import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EditArticlePageRoutingModule } from './edit-article-routing.module';

import { EditArticlePage } from './edit-article.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EditArticlePageRoutingModule,
    ReactiveFormsModule
  ],
  declarations: [EditArticlePage]
})
export class EditArticlePageModule {}
