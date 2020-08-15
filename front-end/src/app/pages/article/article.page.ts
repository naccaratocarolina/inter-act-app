import { Component, OnInit } from '@angular/core';
import { ArticleService } from '../../services/article.service';
import { UserService } from '../../services/user.service';
import { LikeService } from '../../services/like.service';


@Component({
  selector: 'app-article',
  templateUrl: './article.page.html',
  styleUrls: ['./article.page.scss'],
})
export class ArticlePage implements OnInit {

  public user_id:number;
  public userContent = [];
  public article_id:number;
  public articleContent = [];
  public count:number;

  constructor(
    public articleService:ArticleService, 
    public userService:UserService,
    public likeService:LikeService) {

    this.article_id = JSON.parse(localStorage.getItem('article'));
    this.user_id = JSON.parse(localStorage.getItem('user_id'));
   }

  ngOnInit() {

    this.showArticle();
    this.showUser();
    this.hasLike(this.article_id);
  }

  heartIcon: string
  heartBool: boolean;


  public showHeart() {
    if (this.heartBool){
      this.heartIcon = 'heart'
    } else {this.heartIcon = 'heart-outline'}
  }

  showArticle(){
    this.articleService.showArticle(this.article_id).subscribe((response) =>{
      console.log(response.message);
      this.articleContent = response.article; 
      this.count = response.article.likes_count;
    });
  }

  showUser() {
    console.log(this.user_id);
      this.userService.showUser(this.user_id).subscribe((response) =>{
      console.log(response.message);
      this.userContent = response.user; 
    });
  }
  

  public redirectProfile(profile_id) {
    localStorage.setItem('profile_id', JSON.stringify(profile_id));
    window.location.replace('/profile');
  }

  public hasLike(article_id) {
    this.likeService.hasLike(article_id).subscribe((response) => {
      console.log(response);
      if (response) {
        this.heartBool = true;
      }
      else {
        this.heartBool = false;
      }
      this.showHeart();
    });
  }

  public actionLike(article_id) {
      this.likeService.actionLike(article_id).subscribe((response) => {
      console.log(response.message);
      this.count = response.likes_count;
      console.log(response.likes_count);
      this.hasLike(article_id);
    });
  }

  goBack() {
    window.history.back();
  }

}
