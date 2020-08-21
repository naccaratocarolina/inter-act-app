import { Component, OnInit } from '@angular/core';
import { Platform } from '@ionic/angular';
import { SplashScreen } from '@ionic-native/splash-screen/ngx';
import { StatusBar } from '@ionic-native/status-bar/ngx';
import { AuthService } from './services/Auth/auth.service'
import { Router } from '@angular/router';

@Component({
  selector: 'app-root',
  templateUrl: 'app.component.html',
  styleUrls: ['app.component.scss']
})
export class AppComponent implements OnInit {
  public selectedIndex = 0;
  public appPages = [];
  public loggedUser = {profile_picture:null};
  userToken = localStorage.getItem('token');
  public userIsAdmin:boolean;
  public isVisitor:boolean;

  showSidemenu(userToken, userIsAdmin) {
    if(userIsAdmin) {
      this.appPages =[
    {
      title: 'Perfil',
      url: 'profile',
      icon: 'person'
    },
    {
      title: 'Home',
      url: 'home',
      icon: 'home'
    },
    {
      title: 'Editar Perfil',
      url: 'update-profile',
      icon: 'settings'
    },
    {
      title: 'Gerenciar plataforma',
      url: 'manage-plataform',
      icon: 'hammer'
    },
    {
      title: 'Sair',
      url: 'home',
      icon: 'log-out-outline'
    }]
    }

    else if (userToken) {
      this.appPages =[
    {
      title: 'Perfil',
      url: 'profile',
      icon: 'person'
    },
    {
      title: 'Home',
      url: 'home',
      icon: 'home'
    },
    {
      title: 'Editar Perfil',
      url: 'update-profile',
      icon: 'settings'
    },
    {
      title: 'Sair',
      url: 'home',
      icon: 'log-out-outline'
    }]
    }


    else {
       this.appPages = [
      {
        title: 'Login',
        url: 'login',
        icon: 'person'
      },
      {
        title: 'Registre-se',
        url: 'register',
        icon: 'checkbox'
      },
      {
        title: 'Home',
        url: 'home',
        icon: 'home'
      }
    ]}
  }

  constructor(
    private platform: Platform,
    private splashScreen: SplashScreen,
    private statusBar: StatusBar,
    public authService:AuthService,
    private router:Router
  ) {
    this.initializeApp();
  }

  initializeApp() {
    this.platform.ready().then(() => {
      this.statusBar.styleDefault();
      this.splashScreen.hide();
    });
  }

  ngOnInit() {
    const path = window.location.pathname.split('folder/')[1];
    if (path !== undefined) {
      this.selectedIndex = this.appPages.findIndex(page => page.title.toLowerCase() === path.toLowerCase());
    }
    this.getLoggedUser();
    this.setVisitorPic();
    this.showSidemenu(this.userToken, this.userIsAdmin);
  }

  public setVisitorPic(){
    if (this.userToken){}
    else {this.loggedUser.profile_picture = '../assets/logo_2_1.png'}
  }

  //Pega o usuario logado
  public getLoggedUser() {
    this.authService.getDetails().subscribe((response) => {
      this.loggedUser = response.user;
      this.determineUser(response.user.id);
      this.showSidemenu(this.userToken, this.userIsAdmin);
    });
  }

  public determineUser(id){
    if (id==1){
      this.userIsAdmin = true;
    } else {
      this.userIsAdmin=false;
    }
  }

  public redirectManagePlataform(title, user_id) {
    if(title == 'Gerenciar plataforma') {
      window.location.replace('/manage-plataform');
    }
  }

  //Redireciona para a pagina de perfil e salva o id do usuario clicado
  public redirectProfile(title, profile_id) {
    if (title == 'Perfil'){
      localStorage.setItem('profile_id', JSON.stringify(profile_id));
      window.location.replace('/profile');
   }
  }

  //Realiza o logout do usuario
  public logout(title){
    if (title == 'Sair'){
      this.authService.logout().subscribe((response) => {
        localStorage.removeItem('token');
        this.showSidemenu(this.userToken, this.this.userIsAdmin);
        this.router.navigate(['/home']).then(()=>window.location.reload());
      })
    }
  }
}
