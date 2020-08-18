import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: '',
    redirectTo: 'redir-page',
    pathMatch: 'full'
  },
  {
    path: 'redir-page',
    loadChildren: () => import('./pages/redir-page/redir-page.module').then( m => m.RedirPagePageModule)
  },
  {
    path: 'login',
    loadChildren: () => import('./pages/login/login.module').then( m => m.LoginPageModule)
  },
  {
    path: 'register',
    loadChildren: () => import('./pages/register/register.module').then( m => m.RegisterPageModule)
  },
  {
    path: 'home',
    loadChildren: () => import('./pages/home/home.module').then( m => m.HomePageModule)
  },
  {
    path: 'article',
    loadChildren: () => import('./pages/article/article.module').then( m => m.ArticlePageModule)
  },
  {
    path: 'profile',
    loadChildren: () => import('./pages/profile/profile.module').then( m => m.ProfilePageModule)
  },
  {
    path: 'new-article',
    loadChildren: () => import('./pages/new-article/new-article.module').then( m => m.NewArticlePageModule)
  },
  {
    path: 'edit-article',
    loadChildren: () => import('./pages/edit-article/edit-article.module').then( m => m.EditArticlePageModule)
  },
  {
    path: 'update-profile',
    loadChildren: () => import('./pages/update-profile/update-profile.module').then( m => m.UpdateProfilePageModule)
  }
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule {}
