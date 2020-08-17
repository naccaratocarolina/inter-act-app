import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-edit-article',
  templateUrl: './edit-article.page.html',
  styleUrls: ['./edit-article.page.scss'],
})
export class EditArticlePage implements OnInit {

  editArticleForm: FormGroup;

  customActionSheetOptions: any = {
    header: 'Categorias',
    subHeader: 'Escolha uma categoria para o seu artigo'
  };

  constructor(
    public formbuilder: FormBuilder,
    private router: Router) { 

      this.editArticleForm = this.formbuilder.group({
        title: [null],
        subtitle: [null],
        description: [null],
        category: [null],
        image: [null]
      });
    }

  ngOnInit() {
  }

  submitForm(form) {
    console.log(form);
    console.log(form.value);
  }

  //redireciona para pagina home
  public redirectHome() {
    this.router.navigate(['/home']);
  }

}
