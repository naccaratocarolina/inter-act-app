import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router'

@Component({
  selector: 'app-redir-page',
  templateUrl: './redir-page.page.html',
  styleUrls: ['./redir-page.page.scss'],
})
export class RedirPagePage implements OnInit {

  constructor(private router:Router) { }

  ngOnInit() {
  }

  //Redireciona para a pagina principal
  homeRedirect() {
    this.router.navigateByUrl('/home')
  }
}
