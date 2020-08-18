import { Component, OnInit } from '@angular/core';
import { IonicStorageModule } from "@ionic/storage";
import { Router } from '@angular/router';
import { UserService } from '../../services/user.service';
import { ArticleService } from '../../services/article.service';
import { FollowService } from '../../services/follow.service';
import { Injectable } from '@angular/core';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.page.html',
  styleUrls: ['./profile.page.scss'],
})
export class ProfilePage implements OnInit {
  userData = [];
  postsAll:any;
  followText:string;
  profile_id:number;
  followBool:boolean;
  userToken = localStorage.getItem("token");

  constructor(
    private router:Router,
    public userService:UserService,
    public articleService:ArticleService,
    public followService:FollowService,
    ) {
    this.profile_id = JSON.parse(localStorage.getItem('profile_id'));
   }

  ngOnInit() { }

  //Chamada das funcoes para quando o usuario entrar na pagina
  public ionViewWillEnter() {
    this.showUser(this.profile_id);
    this.hasFollow(this.profile_id);
  }

  //Chamada das funcoes para quando o usuario sair da pagina
  public ionViewWillLeave() {

  }

  //Pega o usuario conforme o seu id
  public showUser(profile_id){
    this.userService.showUser(profile_id).subscribe((response) =>{
      this.userData = response.user;
      console.log(response.message);
      this.showUserArticles(this.profile_id);
    })
  }

  //Faz o display dos artigos do usuario atraves do seu id
  public showUserArticles(profile_id){
    this.articleService.indexUserArticles(profile_id).subscribe((response) => {
      this.postsAll = response.articles;
    })
  }

  //Realiza a acao de seguir ou parar de seguir outro usuario
  public actionFollow(user_id) {
    this.followService.actionFollow(user_id).subscribe((response) => {
    this.hasFollow(user_id);
    this.showUser(user_id);
    console.log(response.message)
  });
}

  //Checa se determinado usuario ja foi seguido ou nao pelo usuario logado
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

  //Faz o display do texto do botao de seguir/seguindo conforme a checagem da funcao hasFollow
  public showFollow() {
    if (this.followBool) {
      this.followText = 'Seguindo';
    } else {
      this.followText = 'Seguir';
    }
  }

  public destroyArticle(article_id, profile_id) {
    this.articleService.destroyArticle(article_id).subscribe((response) => {
      console.log(response.message);
      this.showUserArticles(profile_id);
    });
  }

  //Redireciona para a pagina do artigo carregando o id do artigo clicado
  public redirectArticle(article_id) {
    localStorage.setItem('article_id', JSON.stringify(article_id));
    this.router.navigate(['/article']);
  }

  //Acao do botao de voltar na header
  goBack() {
    window.history.back();
  }

  public redirectFollowing(following_id) {
    localStorage.setItem('following_id', JSON.stringify(following_id));
    this.router.navigate(['/following']);
  }

  public redirectFollowers(follower_id) {
    localStorage.setItem('follower_id', JSON.stringify(follower_id));
    this.router.navigate(['/followers']);
  }
}
