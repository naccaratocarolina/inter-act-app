import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { RedirPagePageRoutingModule } from './redir-page-routing.module';

import { RedirPagePage } from './redir-page.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    RedirPagePageRoutingModule
  ],
  declarations: [RedirPagePage]
})
export class RedirPagePageModule {}
