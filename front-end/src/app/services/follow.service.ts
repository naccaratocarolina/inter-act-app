import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class FollowService {

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

  //Function that can attach or detach the relationship of one user following another
  public actionFollow(following_id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'actionFollow/' + following_id, this.httpHeaders);
  }

  //Function that check if an user was already followed
  public hasFollow(following_id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'hasFollow/' + following_id, this.httpHeaders);
  }
  
  //Counts how many followers the user has
  public followingCounter(user_id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'followingCounter/' + user_id, this.httpHeaders);
  }

  //Counts how many people the user follows
  public followersCounter(user_id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'followersCounter/' + user_id, this.httpHeaders);
  }
}
