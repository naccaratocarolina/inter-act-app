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

  //Display a listing of all comments of a certain article
    public indexArticleComment (article_id):Observable<any> {
      this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
      return this.http.get(this.apiUrl + 'indexArticleComment/' + article_id, this.httpHeaders);
    }

  //Creates a new comment
    public postCommentOnArticle (article_id, form):Observable<any> {
      this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
      return this.http.post(this.apiUrl + 'postCommentOnArticle/' + article_id, form, this.httpHeaders);
    }

  //Update the specified comment in storage
  public updateComment (id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.put(this.apiUrl + 'updateComment/' + id, this.httpHeaders);
  }

  //Display the specified comment
  public showComment (id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'showComment/' + id, this.httpHeaders);
  }

  //Remove the comment resource from storage
  public destroyComment (id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.delete(this.apiUrl + 'destroyComment/' + id, this.httpHeaders);
  }

  //Associates a comment to an user
  public indexCommentOwner(id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'indexCommentOwner/' + id, this.httpHeaders)
  }
}
