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
  
  public indexUser():Observable<any> {
    return this.http.get(this.apiUrl + 'indexUser', this.httpHeaders);
  }

  public createUser(form):Observable<any> {
    return this.http.post(this.apiUrl + 'createUser', form, this.httpHeaders);
  }

  public showUser(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'showUser/' + id, this.httpHeaders);
  }

  public updateUser(form, id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.put(this.apiUrl + 'updateUser/' + id, form, this.httpHeaders);
  }

  public destroyUser(id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.delete(this.apiUrl + 'destroyUser/' + id, this.httpHeaders);
  }
}
