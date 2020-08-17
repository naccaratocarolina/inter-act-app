import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ProfilePageRoutingModule } from './profile-routing.module';

import { ProfilePage } from './profile.page';
import { ArticleProfileComponent } from '../../components/article-profile/article-profile.component';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ProfilePageRoutingModule
  ],
  entryComponents: [ArticleProfileComponent],
  declarations: [ProfilePage, ArticleProfileComponent]
})
export class ProfilePageModule {}
