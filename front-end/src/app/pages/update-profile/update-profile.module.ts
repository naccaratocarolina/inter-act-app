import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { UpdateProfilePageRoutingModule } from './update-profile-routing.module';

import { UpdateProfilePage } from './update-profile.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    UpdateProfilePageRoutingModule,
    ReactiveFormsModule
  ],
  declarations: [UpdateProfilePage]
})
export class UpdateProfilePageModule {}
