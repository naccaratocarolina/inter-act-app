import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CommentService {

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

  //Faz o display de todos os comentarios que pertencem a dado artigo
  public indexArticleComment (article_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexArticleComment/' + article_id, this.httpHeaders);
  }

  //Localiza o usuario que postou determinado comentario atravez do id do ultimo
  public indexCommentOwner(id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexCommentOwner/' + id, this.httpHeaders)
  }

  //Localiza determinado comentario pelo seu id
  public showComment (id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'showComment/' + id, this.httpHeaders);
  }

  //Usuario logado posta um novo comentario em determinado artigo
  public postCommentOnArticle (article_id, form):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.post(this.apiUrl + 'postCommentOnArticle/' + article_id, form, this.httpHeaders);
  }

  //Usuario logado atualiza um comentario
  public updateComment (id, form):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.put(this.apiUrl + 'updateComment/' + id, form, this.httpHeaders);
  }

  //Usuario logado deleta um comentario
  public destroyComment (id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.delete(this.apiUrl + 'destroyComment/' + id, this.httpHeaders);
  }
}
