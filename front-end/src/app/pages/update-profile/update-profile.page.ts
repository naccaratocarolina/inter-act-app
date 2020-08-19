import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { AuthService } from '../../services/Auth/auth.service';
import { UserService } from '../../services/user.service';
import { Router } from '@angular/router';
import { Plugins, CameraResultType, CameraSource } from '@capacitor/core';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-update-profile',
  templateUrl: './update-profile.page.html',
  styleUrls: ['./update-profile.page.scss'],
})
export class UpdateProfilePage implements OnInit {

  updateProfileForm: FormGroup;
  public loggedUser = [];
  photo: SafeResourceUrl;

  constructor(
    public formBuilder: FormBuilder,
    public authService: AuthService,
    public userService: UserService,
    private router: Router,
    private sanitizer: DomSanitizer) {
      //Inicializa o formulario de edicao de perfil
      this.updateProfileForm = this.formBuilder.group ({
        name: [null],
        email: [null, [Validators.email]],
        password: [null, [Validators.minLength(6), Validators.maxLength(36)]],
        description: [null, [Validators.minLength(12), Validators.maxLength(83)]],
        profile_picture: [null],
      });
  }

  ngOnInit() {
    this.getLoggedUser();
  }

  //Pega o usuario logado
  public getLoggedUser() {
    this.authService.getDetails().subscribe((response) => {
      this.loggedUser = response.user;
    });
  }

  //Envia o formulario de edicao de usuario
  submitForm(form, user_id) {
    if(this.photo) {
      form.value.profile_picture = this.photo['changingThisBreaksApplicationSecurity'];
    }
    this.userService.updateUser(form.value, user_id).subscribe((response) =>{
      console.log(response.message);
      form.reset();
      this.redirectProfile();
    });
  }

  async takePicture() {
    const profile_picture = await Plugins.Camera.getPhoto({
      quality: 100,
      allowEditing: true,
      saveToGallery: true,
      resultType: CameraResultType.DataUrl,
      source: CameraSource.Camera
    });
    this.photo = this.sanitizer.bypassSecurityTrustResourceUrl(profile_picture && (profile_picture.dataUrl));
  }

  //Redireciona para a pagina de perfil
  public redirectProfile() {
    this.router.navigate(['/profile']);
  }

  //Redireciona para a pagina principal
  public redirectHome() {
    this.router.navigate(['/home']);
  }
}
