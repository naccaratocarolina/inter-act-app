import { Component, OnInit } from '@angular/core';
import { UserService } from "../../services/user.service";

@Component({
  selector: 'app-followers',
  templateUrl: './followers.page.html',
  styleUrls: ['./followers.page.scss'],
})
export class FollowersPage implements OnInit {
  public follower_id:number;
  public followerUsers = [];

  constructor(public userService: UserService) {
    this.follower_id = JSON.parse(localStorage.getItem('follower_id'));
  }

  ngOnInit() { }

  public ionViewWillEnter() {
    this.indexFollowersUsers(this.follower_id);
  }

  public indexFollowersUsers(follower_id) {
    this.userService.indexFollowersUsers(follower_id).subscribe((response) => {
      this.followerUsers = response.followers;
      console.log(response.message);
    });
  }

  //Acao do botao de voltar na header
  goBack() {
    window.history.back();
  }
}
