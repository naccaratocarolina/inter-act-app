import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UserService {

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

  //Display a listing of all users
  public indexUser():Observable<any> {
    return this.http.get(this.apiUrl + 'indexUser', this.httpHeaders);
  }

  //Create a new User with registered-user marker as default
  public createUser(form):Observable<any> {
    return this.http.post(this.apiUrl + 'createUser', form, this.httpHeaders);
  }

  //Display the user matching the id given
  public showUser(user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'showUser/' + user_id, this.httpHeaders);
  }

  //Update the specified user in storage
  public updateUser(form, user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.put(this.apiUrl + 'updateUser/' + user_id, form, this.httpHeaders);
  }

  //Remove the specified user from storage
  public destroyUser(user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.delete(this.apiUrl + 'destroyUser/' + user_id, this.httpHeaders);
  }
}
