import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { ManagePlataformPageRoutingModule } from './manage-plataform-routing.module';

import { ManagePlataformPage } from './manage-plataform.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    ManagePlataformPageRoutingModule
  ],
  declarations: [ManagePlataformPage]
})
export class ManagePlataformPageModule {}
