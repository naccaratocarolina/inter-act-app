import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ArticleService } from '../../services/article.service';

@Component({
  selector: 'app-new-article',
  templateUrl: './new-article.page.html',
  styleUrls: ['./new-article.page.scss'],
})
export class NewArticlePage implements OnInit {

  newArticleForm: FormGroup;

  customActionSheetOptions: any = {
    header: 'Categorias',
    subHeader: 'Escolha uma categoria para o seu artigo'
  };

  constructor(
    public formbuilder: FormBuilder,
    public articleService:ArticleService,
    private router: Router) {

    this.newArticleForm = this.formbuilder.group({
      title: [null, [Validators.required]],
      subtitle: [null, [Validators.required]],
      text: [null, [Validators.required]],
      category: [null, [Validators.required]],
      image: [null]
    });
   }

  ngOnInit() {
  }


  public redirectHome() {
    this.router.navigate(['/home']);
  }

  submitForm(form) {
    this.articleService.createArticle(form.value).subscribe((response) => {
      console.log(response.message);
      form.reset();
      this.redirectHome();
    });
  }
}
