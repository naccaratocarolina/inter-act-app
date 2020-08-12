import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-article',
  templateUrl: './article.page.html',
  styleUrls: ['./article.page.scss'],
})
export class ArticlePage implements OnInit {


  public articleContent:any;

  constructor() { }

  ngOnInit() {

    this.articleContent = 
      {
        id: '1',
        user_id: '',
        title: 'Saladinha fit do Hussein',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: 'salada.jpg',
        category: '',
        date: '',
      };
  }

  heartIcon: string
  heartBool = false

  
  toggleHeart() {
    this.heartBool = !this.heartBool
    if (this.heartBool){
      this.heartIcon = 'heart'
    } else {this.heartIcon = 'heart-outline'}
  }

}
