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
  public loggedUser = [];

  constructor( private router:Router, public profilePage:ProfilePage, public authService: AuthService ) {
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
