import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router'

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  loginForm: FormGroup;

  constructor(public formbuilder: FormBuilder, private router:Router) {
    this.loginForm = this.formbuilder.group({
      email: [null],
      password: [null]
    });
   }

  ngOnInit() {
  }

  submitLogin() {
    
  }


  registerRedirect() {
    this.router.navigateByUrl('/register')
  }

}
