import { Component, OnInit } from '@angular/core';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { ArticleService } from '../../services/article.service';
import { Plugins, CameraResultType, CameraSource } from '@capacitor/core';
import { DomSanitizer, SafeResourceUrl } from '@angular/platform-browser';

@Component({
  selector: 'app-edit-article',
  templateUrl: './edit-article.page.html',
  styleUrls: ['./edit-article.page.scss'],
})
export class EditArticlePage implements OnInit {

  editArticleForm: FormGroup;
  article_id = localStorage.getItem("article_id");
  photo: SafeResourceUrl;

  customActionSheetOptions: any = {
    header: 'Categorias',
    subHeader: 'Escolha uma categoria para o seu artigo'
  };

  constructor(
    public formbuilder: FormBuilder,
    public articleService:ArticleService,
    private router: Router,
    private sanitizer: DomSanitizer) {

      //Inicializa o formulario de edicao do artigo
      this.editArticleForm = this.formbuilder.group({
        title: [null, [Validators.minLength(5), Validators.maxLength(57)]],
        subtitle: [null, [Validators.minLength(12), Validators.maxLength(83)]],
        text: [null],
        category: [null],
        image: [null]
      });
    }

  ngOnInit() { }

  //Envia o formulario de edicao do artigo
  submitForm(form, article_id) {
    if(this.photo) {
      form.value.image = this.photo['changingThisBreaksApplicationSecurity'];
    }
    this.articleService.updateArticle(form.value, article_id).subscribe((response) =>{
      console.log(response.message);
      form.reset();
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
    this.photo = this.sanitizer.bypassSecurityTrustResourceUrl(image && (image.dataUrl));
  }

  //Redireciona para a pagina principal
  public redirectHome() {
    this.router.navigate(['/home']);
  }
}
