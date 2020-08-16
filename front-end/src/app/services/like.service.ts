import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LikeService {

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

  //Usuario logado realiza a acao de dar like ou remover o like de determinado artigo
  public actionLike(article_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'actionLike/' + article_id, this.httpHeaders);
  }

  //Checa se o usuario logado ja curtiu ou nao determinado artigo
  public hasLike(article_id):Observable<any> {
    this.httpHeaders['headers']["Authorization"] = 'Bearer ' + localStorage.getItem('token');
    return this.http.get(this.apiUrl + 'hasLike/' + article_id, this.httpHeaders);
  }
}
