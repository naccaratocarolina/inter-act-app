import { Component, OnInit } from '@angular/core';
import { IonSlides } from '@ionic/angular';
import { Router } from '@angular/router';
import { ArticleService } from '../../services/article.service';
import { Storage, IonicStorageModule } from "@ionic/storage";


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

  constructor(
    private router: Router,
    public articleService: ArticleService) { }

  ngOnInit() { }

  public ionViewWillEnter() {
    //display a listing of all articles
    this.articleService.indexAllArticles().subscribe((response) => {
      this.postsAll = response.articles;
      console.log(this.postsAll);
    });

    //display a listing of the articles posted by users that the logged user follows
    this.articleService.indexFollowingArticles().subscribe((response) => {
      console.log(response.articles);

      for(let i=0; i<response.articles.length; i++) {
        for (let j=0; j<response.articles[i].length; j++) {
          this.postFollowing.push(response.articles[i][j]);
        }
      }
    });
  }

  public ionViewWillLeave() {
    this.postsAll = [];
    this.postFollowing = [];
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

  public redirectArticle(article) {
    localStorage.setItem('article', JSON.stringify(article));
    this.router.navigate(['/article']);
  }

  public redirectNewArticle() {
    this.router.navigate(['/new-article']);
  }
}
