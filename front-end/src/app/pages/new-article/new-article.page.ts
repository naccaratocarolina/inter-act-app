import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';

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
    private router: Router) {

    this.newArticleForm = this.formbuilder.group({
      title: [null],
      subtitle: [null],
      description: [null],
      category: [null],
      image: [null]
    })
   }

  ngOnInit() {
  }

  submitForm(form) {
    console.log(form);
    console.log(form.value);
  }

  public redirectHome() {
    this.router.navigate(['/home']);
  }
}
