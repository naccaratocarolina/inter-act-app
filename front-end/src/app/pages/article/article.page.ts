import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-article',
  templateUrl: './article.page.html',
  styleUrls: ['./article.page.scss'],
})
export class ArticlePage implements OnInit {


  constructor() { }


  articleContent = 
      {
        id: '1',
        user: {username: 'Hussein Latif', user_id: '1'},
        title: 'Saladinha fit do Hussein',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: 'salada.jpg',
        category: '',
        date: '',
        comments: [
          {username: 'Matheus Isidoro', comment: 'Adorei a salada, suas receitas são ótimas, adoro seu conteúdo!!'},
          {username: 'Carolina N.', comment: 'Ameeeeeeeeeei, muito facil de fazer. Mais uma seguidora <3'},
          {username : 'Alexandra Gomes', comment: 'Ótima explicação, gostei bastante. Vou tentar fazer!!'},
        ]
      };

      numOfComments = this.articleContent.comments.length


  ngOnInit() {

    
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
