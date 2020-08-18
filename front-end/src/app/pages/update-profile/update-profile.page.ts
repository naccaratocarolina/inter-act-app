import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { AuthService } from '../../services/Auth/auth.service';
import { UserService } from '../../services/user.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-update-profile',
  templateUrl: './update-profile.page.html',
  styleUrls: ['./update-profile.page.scss'],
})
export class UpdateProfilePage implements OnInit {

  updateProfileForm: FormGroup;
  public loggedUser = [];

  constructor(public formBuilder: FormBuilder, public authService: AuthService, public userService: UserService, private router: Router) {
    this.updateProfileForm = this.formBuilder.group ({
      name: [null],
      email: [null, [Validators.email]],
      password: [null, [Validators.minLength(6), Validators.maxLength(36)]],
      description: [null, [Validators.minLength(12), Validators.maxLength(83)]],
      image: [null],
    })
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

  submitForm(form, user_id) {
    this.userService.updateUser(form.value, user_id).subscribe((response) =>{
      console.log(response.message);
      form.reset();
      this.redirectProfile();
    });
  }

  public redirectProfile() {
    this.router.navigate(['/profile']);
  }

  public redirectHome() {
    this.router.navigate(['/home']);
  }
}
