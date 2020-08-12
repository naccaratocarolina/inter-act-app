import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { AuthService } from "../../services/Auth/auth.service";
import { Router } from '@angular/router';
import { IonicStorageModule } from "@ionic/storage";

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  loginForm: FormGroup;

  constructor( public authService: AuthService, private router:Router, public formbuilder: FormBuilder ) {
    this.loginForm = this.formbuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]]
    });
   }

  ngOnInit() {
  }

  submitLogin(loginForm) {
    if(loginForm.status == "VALID") {
        this.authService.login(loginForm.value).subscribe((response) => {
          console.log(response.message);
          console.log(response.data);

          //Saves on the local storage important informations
          localStorage.setItem('token', response.data.token);
          localStorage.setItem('user_id', response.data.user.id);
          localStorage.setItem('user_name', response.data.user.name);
          localStorage.setItem('user_email', response.data.user.email);
          localStorage.setItem('user_articles', response.data.articles);
          localStorage.setItem('user_comments', response.data.comments);

          //redirects to home page
          this.router.navigate(['/home']);
        });
    }
  }

  registerRedirect() {
    this.router.navigateByUrl('/register')
  }

}
