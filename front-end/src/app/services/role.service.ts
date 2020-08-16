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

  //Moderador pode atribuir um marcador de moderador a um usuario registrado na plataforma
  public addRole(role_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.post(this.apiUrl + 'addRole/' + role_id, null, this.httpHeaders)
  }

}
