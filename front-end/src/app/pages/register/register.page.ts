import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';


@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {

  registerForm: FormGroup;

  constructor(private router:Router, public formbuilder: FormBuilder) {
    this.registerForm = this.formbuilder.group({
      name: [null],
      email: [null],
      password: [null]
    });
   }

  ngOnInit() {
  }

  submitRegister() {
    
  }

}
