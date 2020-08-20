import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { AuthService } from "../../services/Auth/auth.service";
import { Router } from '@angular/router';
import { IonicStorageModule } from "@ionic/storage";
import { ToastController } from '@ionic/angular';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  loginForm: FormGroup;

  constructor(
    public authService: AuthService,
    private router:Router,
    public formbuilder: FormBuilder,
    public toastController: ToastController) {
    //Inicializa o formulario de login
    this.loginForm = this.formbuilder.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required]]
    });
   }

  ngOnInit() {
  }

  //Realiza o login do usuario na plataforma
  public submitLogin(loginForm) {
    if(loginForm.status == "VALID") {
        this.authService.login(loginForm.value).subscribe((response) => {
          console.log(response.message);
          localStorage.setItem('token', response.data.token);
          this.router.navigate(['/home']).then(()=>window.location.reload());
        }, (err) => {
          console.log(err);
          this.loginErrorToast(err.error.message);
        });
    }
  }

  async loginErrorToast(message) {
    const toast = await this.toastController.create({
      message: message,
      duration: 3000
    });
    toast.present();
  }

  //Redireciona para a pagina de registro
  registerRedirect() {
    this.router.navigateByUrl('/register');
  }
}
