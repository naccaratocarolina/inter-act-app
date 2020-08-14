import { Component, OnInit } from '@angular/core';
import { ArticleService } from '../../services/article.service';
import { IonicStorageModule } from "@ionic/storage";
import { Router } from '@angular/router';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.page.html',
  styleUrls: ['./profile.page.scss'],
})
export class ProfilePage implements OnInit {

  constructor(private router:Router) { }

postsAll:any;
followText:string;

  ngOnInit() {
    this.toggleFollow()
    this.postsAll = [
      {
        id: '1',
        user_id: '',
        title: 'Saladinha fit do Hussein',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: '../../../assets/salada.jpg',
        category: '',
        date: '',
      },
      {
        id: '2',
        user_id: '',
        title: 'Yoga em casa',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: '../../../assets/yoga.jpg',
        category: '',
        date: '',
      },
      {
        id: '3',
        user_id: '',
        title: 'Mixto Quiente',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: '../../../assets/food.jpg',
        category: '',
        date: '',
      },
      {
        id: '4',
        user_id: '',
        title: 'Street Dance',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: '../../../assets/streetdance.jpg',
        category: '',
        date: '',
      },
    ];
  }


  followBool=false

  toggleFollow(){
    this.followBool=!this.followBool
    if (this.followBool)
    {this.followText='Seguindo'}
       else {this.followText='Seguir'}
  }


  followUser () {
    this.toggleFollow()
  }

  public redirectArticle() {
    this.router.navigate(['/article']);
  }

  }
