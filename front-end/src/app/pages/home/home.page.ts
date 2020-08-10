import { Component, OnInit } from '@angular/core';
import { IonSlides } from '@ionic/angular';

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

  constructor() { }

  ngOnInit() {
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
}
