import { Component, OnInit } from '@angular/core';
import { IonicStorageModule } from "@ionic/storage";
import { Router } from '@angular/router';
import {UserService} from '../../services/user.service';
import {ArticleService} from '../../services/article.service';
import {FollowService} from '../../services/follow.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.page.html',
  styleUrls: ['./profile.page.scss'],
})
export class ProfilePage implements OnInit {

  postsAll:any;
  followText:string;
  profile_id:number;
  userData = [];
  followBool:boolean;

  constructor(
    private router:Router, 
    public userService:UserService,
    public articleService:ArticleService,
    public followService:FollowService,
    ) {
    this.profile_id = JSON.parse(localStorage.getItem('profile_id'));
   }

  ngOnInit() {
  }

  public showUserArticles(profile_id){
    this.articleService.indexUserArticles(profile_id).subscribe((response) => {
      this.postsAll = response.articles;
    })
  }

  public showUser(profile_id){
    this.userService.showUser(profile_id).subscribe((response) =>{
      this.userData = response.user;
      console.log(response.message);
      this.showUserArticles(this.profile_id);
    })
  }

  public ionViewWillEnter() {
    this.showUser(this.profile_id);
    this.hasFollow(this.profile_id);
  }

  public ionViewWillLeave() {
    localStorage.setItem('profile_id',null)
  }

  //Like or dislike an article
  public actionFollow(user_id) {
    this.followService.actionFollow(user_id).subscribe((response) => {
    this.hasFollow(user_id);
    this.showUser(user_id);
    console.log(response.message)
  });
}

//Check if the article war already liked by the logged user or not
public hasFollow(user_id) {
  this.followService.hasFollow(user_id).subscribe((response) => {
    if (response) {
      this.followBool = true;
    }
    else {
      this.followBool = false;
    }
    this.showFollow();
  });
}

//Display the icon checking if it has already been liked or not
public showFollow() {
  if (this.followBool) {
    this.followText = 'Seguindo';
  } else {
    this.followText = 'Seguir';
  }
}

public redirectArticle(article_id) {
  localStorage.setItem('article_id', JSON.stringify(article_id));
  this.router.navigate(['/article']);
}
  }