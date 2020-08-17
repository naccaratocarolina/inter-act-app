import { Component, OnInit, Input } from '@angular/core';
import { ArticlePage } from '../../pages/article/article.page';
//import { Events } from 'ionic-angular';

@Component({
  selector: 'app-comment',
  templateUrl: './comment.component.html',
  styleUrls: ['./comment.component.scss'],
})
export class CommentComponent implements OnInit {
  @Input() comment;
  public article_id:number;
  public canEdit:boolean = true;
  public textEditForm:string = '';
  public comment_id:number;

  constructor(public articlePage:ArticlePage) {
    this.article_id = JSON.parse(localStorage.getItem('article_id'));
    /*
    this.events.publish('textEditForm', this.textEditForm);
    this.events.publish('comment_id', this.comment_id);
    this.events.publish('canEdit', this.canEdit);*/
  }

  ngOnInit() { }

  public destroyComment(comment_id, article_id) {
    this.articlePage.destroyComment(comment_id, article_id);
  }

  getCommentId(comment) {
    this.textEditForm = comment.commentary;
    this.comment_id = comment.id;
    this.canEdit = true;
  }
}
