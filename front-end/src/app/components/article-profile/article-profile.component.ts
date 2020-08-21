import { Component, OnInit, Input } from '@angular/core';
import { Router } from '@angular/router';
import { ProfilePage } from '../../pages/profile/profile.page';
import { AuthService } from "../../services/Auth/auth.service";

@Component({
  selector: 'app-article-profile',
  templateUrl: './article-profile.component.html',
  styleUrls: ['./article-profile.component.scss'],
})
export class ArticleProfileComponent implements OnInit {
  @Input() All;
  public loggedUserId:number;
  public userIsAdmin:boolean;
  public userOwnProfile:boolean;
  public profile_id = JSON.parse(localStorage.getItem('profile_id'));

  constructor( private router:Router, public profilePage:ProfilePage, public authService: AuthService ) {
  }

  ngOnInit() {
    this.getLoggedUser();
  }

  //Pega o usuario logado e define
  public getLoggedUser() {
    this.authService.getDetails().subscribe((response) => {
      this.loggedUserId = response.user.id;
      this.determineUser();
    });
  }

  public determineUser(){
    if (this.loggedUserId==this.profile_id){
      this.userOwnProfile=true;
    } else {this.userOwnProfile=false};
    if (this.loggedUserId==1){
      this.userIsAdmin = true
    } else {this.userIsAdmin=false}
  }

  //Funcao que deleta um artigo
  public destroyArticle(article_id, profile_id) {
    this.profilePage.destroyArticle(article_id, profile_id);
  }

  //Redireciona para a pagina do artigo carregando o id do artigo clicado
  public redirectArticle(article_id) {
    localStorage.setItem('article_id', JSON.stringify(article_id));
    this.router.navigate(['/article']);
  }

  //Redireciona para a pagina de edicao de artigo
  public redirectEditArticle(article_id) {
    localStorage.setItem('article_id', JSON.stringify(article_id));
    this.router.navigate(['/edit-article']);
  }
}
