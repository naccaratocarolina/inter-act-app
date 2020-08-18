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

  //Usuario logado realiza a acao de seguir ou parar de seguir outro usuario
  public actionFollow(following_id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'actionFollow/' + following_id, this.httpHeaders);
  }

  public removeFollow(following_id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'removeFollow/' + following_id, this.httpHeaders);
  }

  //Checa se o usuario logado ja seguiu ou nao outro usuario
  public hasFollow(following_id):Observable<any>{
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'hasFollow/' + following_id, this.httpHeaders);
  }
}
