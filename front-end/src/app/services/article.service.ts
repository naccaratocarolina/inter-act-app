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
}
