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

  //Display a listing of all articles
  public indexAllArticles ():Observable<any> {
    return this.http.get(this.apiUrl + 'indexAllArticles', this.httpHeaders);
  }

  //Display a listing of the resource that belongs to the authenticated user
  public indexUserArticles():Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexUserArticles', this.httpHeaders);
  }

  //Display the article owner
  public indexArticleOwner(article_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexArticleOwner/' + article_id, this.httpHeaders);
  }

  //Display a listing of articles that belongs to the users that the user making the request follows
  public indexFollowingArticles():Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexFollowingArticles', this.httpHeaders);
  }

  public likesCounter(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'likesCounter/' + id, this.httpHeaders);
  }

  // /Display the specified article
  public showArticle(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'showArticle/' + id, this.httpHeaders);
  }

  //Creates a new instance of article
  public createArticle(form):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.post(this.apiUrl + 'createArticle', form, this.httpHeaders);
  }

  //Update the specified article in storage
  public updateArticle(form, id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.put(this.apiUrl + 'updateArticle/' + id, form, this.httpHeaders);
  }

  //Remove the specified article from storage
  public destroyArticle(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.delete(this.apiUrl + 'destroyArticle/' + id, this.httpHeaders);
  }
}
