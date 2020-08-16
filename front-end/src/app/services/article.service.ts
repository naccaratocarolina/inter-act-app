import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ArticleService {

  //URL da API
  apiUrl: string = "http://localhost:8000/api/";

  //Headers do request
  httpHeaders: object = {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    }
  }

  constructor(public http:HttpClient) { }

  //Faz o display de todos os artigos
  public indexAllArticles ():Observable<any> {
    return this.http.get(this.apiUrl + 'indexAllArticles', this.httpHeaders);
  }

  //Faz o display de todos os artigos que foram postados pelo user_id dado
  public indexUserArticles(user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexUserArticles/' + user_id, this.httpHeaders);
  }

  //Localiza o usuario que postou o artigo dado
  public indexArticleOwner(article_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexArticleOwner/' + article_id, this.httpHeaders);
  }

  //Faz o display dos artigos postados pelo usuario que esta logado na plataforma
  public indexFollowingArticles():Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexFollowingArticles', this.httpHeaders);
  }

  //Localiza o artigo especifido atravez do id dado
  public showArticle(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'showArticle/' + id, this.httpHeaders);
  }

  //Usuario logado cria um novo artigo
  public createArticle(form):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.post(this.apiUrl + 'createArticle', form, this.httpHeaders);
  }

  //Usuario logado atualiza um artigo ja existente
  public updateArticle(form, id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.put(this.apiUrl + 'updateArticle/' + id, form, this.httpHeaders);
  }

  //Usuario logado deleta um artigo
  public destroyArticle(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.delete(this.apiUrl + 'destroyArticle/' + id, this.httpHeaders);
  }
}
