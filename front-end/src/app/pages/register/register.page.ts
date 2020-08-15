import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { AuthService } from "../../services/Auth/auth.service";
import { Router } from '@angular/router';
import { IonicStorageModule } from "@ionic/storage";

@Component({
  selector: 'app-register',
  templateUrl: './register.page.html',
  styleUrls: ['./register.page.scss'],
})
export class RegisterPage implements OnInit {

  registerForm: FormGroup;

  constructor( public authService: AuthService, private router:Router, public formbuilder: FormBuilder ) {
    this.registerForm = this.formbuilder.group({
      name: ['', [Validators.required]],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]]
    });
   }

  ngOnInit() {
  }

  submitRegister(registerForm) {
    if(registerForm.status == "VALID") {
      this.authService.register(registerForm.value).subscribe((response) => {
        console.log(response.message);

        //redirects to home page
        this.router.navigate(['/home']);
      });
    }
  }

}
