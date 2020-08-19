import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ArticleService } from '../../services/article.service';

import { Plugins, CameraResultType, CameraSource } from '@capacitor/core';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-new-article',
  templateUrl: './new-article.page.html',
  styleUrls: ['./new-article.page.scss'],
})
export class NewArticlePage implements OnInit {

  newArticleForm: FormGroup;
  photo: SafeResourceUrl;

  customActionSheetOptions: any = {
    header: 'Escolha uma categoria para o seu artigo',
  };

  constructor(
    public formbuilder: FormBuilder,
    public articleService:ArticleService,
    private router: Router,
    private sanitizer: DomSanitizer) {

      //Inicializa o formulario de criacao de um novo artigo
      this.newArticleForm = this.formbuilder.group({
        title: [null, [Validators.required, Validators.minLength(5), Validators.maxLength(57)]],
        subtitle: [null, [Validators.required, Validators.minLength(12), Validators.maxLength(83)]],
        text: [null, [Validators.required]],
        category: [null, [Validators.required]],
        image: [null]
      });
   }

  ngOnInit() { }

  //Redireciona para a pagina principal
  public redirectHome() {
    this.router.navigate(['/home']);
  }

  //Envia o formulario de criacao de um novo artigo
  submitForm(form) {
    if(this.photo) {
      form.value.image = this.photo['changingThisBreaksApplicationSecurity'];
    }
    this.articleService.createArticle(form.value).subscribe((response) => {
      console.log(response.message);
      form.reset();
      console.log(response.article);
      this.redirectHome();
    });
  }

  async takePicture() {
    const image = await Plugins.Camera.getPhoto({
      quality: 100,
      allowEditing: true,
      saveToGallery: true,
      resultType: CameraResultType.DataUrl,
      source: CameraSource.Camera
    });
    console.log(image);
    this.photo = this.sanitizer.bypassSecurityTrustResourceUrl(image && (image.dataUrl));
    console.log(this.photo);
  }
}
