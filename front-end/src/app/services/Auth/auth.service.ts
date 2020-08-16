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
  httpHeaders: any = {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  }

  constructor( public http:HttpClient ) { }

  //Cadastra um novo usuario na plataforma com o marcador de registered-user como default
  public register(request_form): Observable<any> {
    return this.http.post(this.apiUrl + 'register', request_form, this.httpHeaders);
  }

  //Realiza o login de um usuario ja cadastrado na plataforma
  public login(request_form): Observable<any> {
    return this.http.post(this.apiUrl + 'login', request_form, this.httpHeaders);
  }

  //Pega as informacoes do usuario logado
  public getDetails(): Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'getDetails', this.httpHeaders);
  }

  //Realiza o logout do usuario na plataforma
  public logout(): Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'logout', this.httpHeaders);
  }
}
