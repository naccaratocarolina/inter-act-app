import { Component, OnInit, Input } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-article-home',
  templateUrl: './article-home.component.html',
  styleUrls: ['./article-home.component.scss'],
})
export class ArticleHomeComponent implements OnInit {
  @Input() All;
  @Input() Following;

  constructor(private router: Router) { }

  ngOnInit() {}

  //redirects to the create article page
  public redirectArticle(article_id) {
    localStorage.setItem('article_id', JSON.stringify(article_id));
    this.router.navigate(['/article']);
  }
}
