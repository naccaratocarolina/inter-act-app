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

  userToken = localStorage.getItem("token");
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

  //Chamada das funcoes para quando o usuario entrar na pagina
  public ionViewWillEnter() {
    this.indexAllArticles();
    this.indexFollowingArticles();
  }

  //Chamada das funcoes para quando o usuario sair da pagina
  public ionViewWillLeave() {
    this.postsAll = [];
    this.postFollowing = [];
  }

  //Faz o display de todos os artigos da plataforma
  public indexAllArticles() {
    this.articleService.indexAllArticles().subscribe((response) => {
      this.postsAll = response.articles;
      console.log(this.postsAll);
    });
  }

  //Faz o display dos artigos filtrando pelos usuarios que o usuario logado segue
  public indexFollowingArticles() {
    this.articleService.indexFollowingArticles().subscribe((response) => {
      console.log(response.articles);

      for(let i=0; i<response.articles.length; i++) {
        for (let j=0; j<response.articles[i].length; j++) {
          this.postFollowing.push(response.articles[i][j]);
        }
      }
    });
  }

  //Redireciona para a pagina de artigo carregando o id do artigo clicado
  public redirectArticle(article_id) {
    localStorage.setItem('article_id', JSON.stringify(article_id));
    this.router.navigate(['/article']);
  }

  //Redireciona para a pagina de criacao de um novo artigo
  public redirectNewArticle() {
    this.router.navigate(['/new-article']);
  }

  //Redireciona para a pagina de criacao de conta
  public redirectRegisterPage() {
    this.router.navigate(['/register']);
  }

  //Funcoes que fazem as abas de Todos e Seguindo da pagina principal
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
