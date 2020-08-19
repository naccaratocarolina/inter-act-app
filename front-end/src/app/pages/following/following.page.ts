import { Component, OnInit } from '@angular/core';
import { UserService } from "../../services/user.service";
import { FollowService } from '../../services/follow.service';
import { AuthService } from "../../services/Auth/auth.service";

@Component({
  selector: 'app-following',
  templateUrl: './following.page.html',
  styleUrls: ['./following.page.scss'],
})
export class FollowingPage implements OnInit {
  public following_id:number;
  public loggedUser = [];
  public followingUsers = [];
  public clickedUser = [];

  constructor(public userService: UserService, public followService:FollowService, public authService: AuthService) {
    this.following_id = JSON.parse(localStorage.getItem('following_id'));
  }

  ngOnInit() {
    console.log(this.followingUsers);
  }

  public ionViewWillEnter() {
    this.getLoggedUser();
    this.showUser(this.following_id);
    this.indexFollowingUsers(this.following_id);
  }

  //Pega o usuario logado
  public getLoggedUser() {
    this.authService.getDetails().subscribe((response) => {
      this.loggedUser = response.user;
    });
  }

  //Pega o usuario que foi clicado
  public showUser(following_id) {
    this.userService.showUser(following_id).subscribe((response) => {
      this.clickedUser = response.user;
    });
  }

  //Lista os usuarios
  public indexFollowingUsers(following_id) {
    this.userService.indexFollowingUsers(following_id).subscribe((response) => {
      this.followingUsers = response.following;
      console.log(response.message);
    });
  }

  //Realiza a acao de seguir ou parar de seguir outro usuario
  public removeFollow(user_id, following_id) {
    this.followService.removeFollow(user_id).subscribe((response) => {
    console.log(response.message);
    this.indexFollowingUsers(following_id);
  });
  }

  //Acao do botao de voltar na header
  goBack() {
    window.history.back();
  }
}
