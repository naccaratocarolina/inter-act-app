import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})

/**
 *
 * This service is exclusive for the Moderator.
 *
 */

export class RoleService {

  constructor(public http:HttpClient) { }

    //URL da API
    apiUrl: string = "http://localhost:8000/api/";

    //Headers do request
    httpHeaders: object = {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      }
    }

  //Add a role to the authenticated user
    public addRole(role_id):Observable<any> {
      this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
      return this.http.post(this.apiUrl + 'addRole/' + role_id, null, this.httpHeaders)
  }

}
