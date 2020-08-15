import { Component, OnInit } from '@angular/core';
import { ArticleService } from '../../services/article.service';
import { LikeService } from '../../services/like.service';


@Component({
  selector: 'app-article',
  templateUrl: './article.page.html',
  styleUrls: ['./article.page.scss'],
})
export class ArticlePage implements OnInit {

  public article_owner = [];
  public articleContent = [];
  public article_id:number;
  public count:number;
  heartIcon: string;
  heartBool: boolean;

  constructor(public articleService:ArticleService, public likeService:LikeService) {
    this.article_id = JSON.parse(localStorage.getItem('article_id'));
   }

  ngOnInit() { }

  public ionViewWillEnter() {
    this.showArticle();
    this.hasLike(this.article_id);
  }

  public ionViewWillLeave() {
    this.articleContent = [];
    this.article_owner = [];
  }

  //Get the article by its id
  public showArticle(){
    this.articleService.showArticle(this.article_id).subscribe((response) =>{
      console.log(response.message);
      this.articleContent = response.article;
      this.count = response.article.likes_count;
      this.indexArticleOwner(this.article_id);
    });
  }

  //Get the article owner also by its id
  public indexArticleOwner(article_id) {
    this.articleService.indexArticleOwner(article_id).subscribe((response) => {
      console.log(response.message);
      this.article_owner = response.article_owner;
    });
  }

  //Like or dislike an article
  public actionLike(article_id) {
      this.likeService.actionLike(article_id).subscribe((response) => {
      console.log(response.message);
      this.count = response.likes_count;
      this.hasLike(article_id);
    });
  }

  //Check if the article war already liked by the logged user or not
  public hasLike(article_id) {
    this.likeService.hasLike(article_id).subscribe((response) => {
      if (response) {
        this.heartBool = true;
      }
      else {
        this.heartBool = false;
      }
      this.showHeart();
    });
  }

  //Display the icon checking if it has already been liked or not
  public showHeart() {
    if (this.heartBool) {
      this.heartIcon = 'heart';
    } else {
      this.heartIcon = 'heart-outline';
    }
  }

  //Redirects to the user's profile
  public redirectProfile(profile_id) {
    localStorage.setItem('profile_id', JSON.stringify(profile_id));
    window.location.replace('/profile');
  }

  goBack() {
    window.history.back();
  }
}
