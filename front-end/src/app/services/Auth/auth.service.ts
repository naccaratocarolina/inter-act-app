import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient, HttpHeaders } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  //Back-end route
  apiUrl:string = 'http://localhost:8000/api/';

  //Http Request Header
  httpHeaders: object = {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  }

  constructor( public http:HttpClient ) { }

  //register a new User
  public register(request_form): Observable<any> {
    return this.http.post(this.httpHeaders + 'register', request_form, this.httpHeaders);
  }

  //login an existent User
  public login(request_form): Observable<any> {
    return this.http.post(this.httpHeaders + 'login', request_form, this.httpHeaders);
  }

  public getDetails(): OBservable<any> {
    //Authorization->Bearer . token
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.post(this.httpHeaders + 'getDetails', this.httpHeaders);
  }

  //logout of an existent User
  public logout(): OBservable<any> {
    //Authorization->Bearer . token
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.httpHeaders + 'logout', this.httpHeaders);
  }
}
