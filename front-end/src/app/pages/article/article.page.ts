import { Component, OnInit, Output } from '@angular/core';
import { Injectable } from '@angular/core';
import { ArticleService } from '../../services/article.service';
import { LikeService } from '../../services/like.service';
import { CommentService } from '../../services/comment.service';
import { AuthService } from "../../services/Auth/auth.service";
import { FormGroup, FormBuilder, Validators } from '@angular/forms';

@Component({
  selector: 'app-article',
  templateUrl: './article.page.html',
  styleUrls: ['./article.page.scss'],
})
export class ArticlePage implements OnInit {
  public article_id:number;
  public count:number;
  public numOfComments:number;
  public articleComments = [];
  public articleContent = [];
  public article_owner = [];
  public loggedUser = {profile_picture:null};
  public comment = [];
  public commentForm: FormGroup;
  public commentEditForm: FormGroup;
  public heartIcon: string;
  public heartBool: boolean;
  public userToken = localStorage.getItem("token");

  constructor(
    public articleService:ArticleService,
    public likeService:LikeService,
    public commentService:CommentService,
    public authService: AuthService,
    public formBuilder:FormBuilder) {
    this.article_id = JSON.parse(localStorage.getItem('article_id'));

    this.commentForm = this.formBuilder.group({
      commentary: [null, [Validators.required]]
    });
   }

  ngOnInit() { this.setVisitorPic(); }

  public setVisitorPic(){
    if (this.userToken){}
    else {this.loggedUser.profile_picture = '../assets/logo_2_1.png'}
  }

  //Chamada das funcoes para quando o usuario entrar na pagina
  public ionViewWillEnter() {
    this.getLoggedUser();
    this.showArticle();
    this.hasLike(this.article_id);
    this.showComments(this.article_id);
  }

  //Chamada das funcoes para quando o usuario sair da pagina
  public ionViewWillLeave() {
    this.articleContent = [];
    this.article_owner = [];
    //localStorage.setItem('article_id',null)
  }

  //Pega o usuario logado
  public getLoggedUser() {
    this.authService.getDetails().subscribe((response) => {
      this.loggedUser = response.user;
    });
  }

  //Faz o display do artigo conforme o seu id
  public showArticle(){
    this.articleService.showArticle(this.article_id).subscribe((response) =>{
      console.log(response.message);
      this.articleContent = response.article;
      this.count = response.article.likes_count;
      this.indexArticleOwner(this.article_id);
    });
  }

  //Pega o dono do artigo confirme o article_id
  public indexArticleOwner(article_id) {
    this.articleService.indexArticleOwner(article_id).subscribe((response) => {
      console.log(response.message);
      this.article_owner = response.article_owner;
    });
  }

  //Faz o display do dono do comentario
  public assignCommentToUser(){
    for (let i=0; i<this.articleComments.length; i++){
      let id = this.articleComments[i].id
      this.commentService.indexCommentOwner(id).subscribe((response) =>{
        console.log(response.comment_owner.name)
        this.articleComments[i].username = response.comment_owner.name;
      });
    }
    this.numOfComments = this.articleComments.length;
  }

  //Printa todos os comentarios correspondendes ao artigo
  public showComments(article_id){
    this.commentService.indexArticleComment(article_id).subscribe((response) =>{
      this.articleComments = response.comments;
      console.log(this.articleComments);
      this.assignCommentToUser();
    });
  }

  //Usuario logado posta um novo comentario
  public postCommentOnArticle(article_id,form) {
    this.commentService.postCommentOnArticle(article_id, form.value).subscribe((response) => {
      console.log(response.message);
      form.reset();
      this.showComments(article_id);
    });
  }

  //Deleta um comentario atraves do seu id
  public destroyComment(comment_id, article_id) {
    this.commentService.destroyComment(comment_id).subscribe((response) => {
      console.log(response.message);
      this.showComments(article_id);
    });
  }

  //Realiza a acao de like ou dislike de um artigo
  public actionLike(article_id) {
      this.likeService.actionLike(article_id).subscribe((response) => {
      console.log(response.message);
      this.count = response.likes_count;
      this.hasLike(article_id);
    });
  }

  //Verifica se o usuario logado ja deu like ou nao no artigo e salva essa informacao
  public hasLike(article_id) {
    if (this.userToken) {
      this.likeService.hasLike(article_id).subscribe((response) => {
      if (response) {
        this.heartBool = true;
      }
      else {
        this.heartBool = false;
      }
      this.showHeart();
    });
    } else {
      this.heartBool = false;
      this.showHeart();
    }
  }

  //Faz o display do icone de like conforme o artigo ja foi curtido ou nao
  public showHeart() {
    if (this.heartBool) {
      this.heartIcon = 'heart';
    } else {
      this.heartIcon = 'heart-outline';
    }
  }

  //Redireciona para a pagina de perfil e salva o id do usuario clicado
  public redirectProfile(profile_id) {
    localStorage.setItem('profile_id', JSON.stringify(profile_id));
    window.location.replace('/profile');
  }

  //Acao do botao de voltar na header
  goBack() {
    window.history.back();
  }
}
