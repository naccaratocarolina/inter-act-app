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

  public indexAllArticles ():Observable<any> {
    return this.http.get(this.apiUrl + 'indexAllArticles', this.httpHeaders);
  }

  public indexFollowingArticles():Observable<any> {
    //Authorization->Bearer . token
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexFollowingArticles', this.httpHeaders);
  }

  public likesCounter(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'likesCounter/' + id, this.httpHeaders);
  }

  public showArticle(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'showArticle/' + id, this.httpHeaders);
  }
  
  public createArticle(form):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.post(this.apiUrl + 'createArticle', form, this.httpHeaders);
  }

  public updateArticle(form, id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.put(this.apiUrl + 'updateArticle/' + id, form, this.httpHeaders);
  }

  public destroyArticle(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.delete(this.apiUrl + 'destroyArticle/' + id, this.httpHeaders);
  }
}
