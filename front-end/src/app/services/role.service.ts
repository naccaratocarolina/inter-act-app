import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})

/**
 *
 * Essa service eh exclusiva para o moderador.
 *
 */

export class RoleService {

  //URL da API
  apiUrl: string = "http://localhost:8000/api/";

  //Headers do request
  httpHeaders: object = {
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    }
  }

  constructor( public http:HttpClient ) { }

  //Moderador adiciona o marcador de moderador a outro usuario normal
  public assignModerator(user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'assignModerator/' + user_id, this.httpHeaders);
  }

  //Funcao que verifica se o usuario logado possui marcador de moderador
  public isModerator(user_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'isModerator/' + user_id, this.httpHeaders);
  }
}
