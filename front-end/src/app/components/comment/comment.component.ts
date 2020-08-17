import { Component, OnInit, Input } from '@angular/core';
import { ArticlePage } from '../../pages/article/article.page';

@Component({
  selector: 'app-comment',
  templateUrl: './comment.component.html',
  styleUrls: ['./comment.component.scss'],
})
export class CommentComponent implements OnInit {
  @Input() comment;
  public article_id:number;

  constructor(public articlePage:ArticlePage) {
    this.article_id = JSON.parse(localStorage.getItem('article_id'));
  }

  ngOnInit() { }

  public destroyComment(comment_id, article_id) {
    this.articlePage.destroyComment(comment_id, article_id);
  }
}
