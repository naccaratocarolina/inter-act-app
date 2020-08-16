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
  public appPages = []
  public loggedUser = [];
  userToken = localStorage.getItem('token');

  showSidemenu(userToken) {
    if (userToken) {
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
      title: 'Configurações',
      url: 'config',
      icon: 'settings'
    },
    {
      title: 'Sair',
      url: '/folder/Archived',
      icon: 'log-out-outline'
    }]
    } else { this.appPages = [
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
      }]}
  }

  constructor(
    private platform: Platform,
    private splashScreen: SplashScreen,
    private statusBar: StatusBar,
    public authService:AuthService,
    private router:Router,
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
    this.showSidemenu(this.userToken);
    this.getLoggedUser();
  }

  //Pega o usuario logado
  public getLoggedUser() {
    this.authService.getDetails().subscribe((response) => {
      this.loggedUser = response.user;
    });
  }

  //Realiza o logout do usuario
  public logout(title){
    if (title == 'Sair'){
      this.authService.logout().subscribe((response) => {
        localStorage.removeItem('token');
        this.showSidemenu(this.userToken);
        this.router.navigate(['/home']).then(()=>window.location.reload());
      })
    }
  }
}
