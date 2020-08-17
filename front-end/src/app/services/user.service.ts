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

  token:string;

  constructor(public http:HttpClient) { }

  //Faz o display de todos os usuarios
  public indexUser():Observable<any> {
    return this.http.get(this.apiUrl + 'indexUser', this.httpHeaders);
  }

  //Cria um novo usuario com o marcador de registered-user como default
  public createUser(form):Observable<any> {
    return this.http.post(this.apiUrl + 'createUser', form, this.httpHeaders);
  }

  //Localiza o usuario conforme o seu id
  public showUser(user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'showUser/' + user_id, this.httpHeaders);
  }

  //Edita o usuario especifico no storage
  public updateUser(form, user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.put(this.apiUrl + 'updateUser/' + user_id, form, this.httpHeaders);
  }

  //Remove o usuario especifico do storage
  public destroyUser(user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.delete(this.apiUrl + 'destroyUser/' + user_id, this.httpHeaders);
  }
}
