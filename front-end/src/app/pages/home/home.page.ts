import { Component, OnInit } from '@angular/core';
import { IonSlides } from '@ionic/angular';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: './home.page.html',
  styleUrls: ['./home.page.scss'],
})
export class HomePage implements OnInit {


  selectedSlide: any;
  segment = 0;
  sliderOptions = {
    initialSlide: 0,
    slidesPerView: 1,
    speed: 400
  }
  
  //Array com os posts da aba Todos
  public postsAll:any = [];
  
  //Array com os posts da aba seguindo
  public postFollowing:any =[]

  constructor(private router: Router) { }

  ngOnInit() {
    this.postsAll = [
      {
        id: '1',
        user_id: '',
        title: 'Saladinha fit do Hussein',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: 'salada.jpg',
        category: '',
        date: '',
      },
      {
        id: '2',
        user_id: '',
        title: 'Yoga em casa',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: 'yoga.jpg',
        category: '',
        date: '',
      },
      {
        id: '3',
        user_id: '',
        title: 'Mixto Quiente',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: 'food.jpg',
        category: '',
        date: '',
      },
      {
        id: '4',
        user_id: '',
        title: 'Street Dance',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: 'streetdance.jpg',
        category: '',
        date: '',
      },
    ];

    this.postFollowing = [
      {
        id: '3',
        user_id: '',
        title: 'Mixto Quiente',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: 'food.jpg',
        category: '',
        date: '',
      },
      {
        id: '4',
        user_id: '',
        title: 'Street Dance',
        subtitle: "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.",
        text: '',
        image: 'streetdance.jpg',
        category: '',
        date: '',
      },
    ];
  }

  async segmentChanged(ev) {
    await this.selectedSlide.slideTo(this.segment)
  }

  slideShanged(slides : IonSlides) {

    this.selectedSlide = slides;
    slides.getActiveIndex().then(seLectedIndex =>{
      this.segment = seLectedIndex;
    })
  }

  public redirectArticle() {
    this.router.navigate(['/article']);
  }
}
