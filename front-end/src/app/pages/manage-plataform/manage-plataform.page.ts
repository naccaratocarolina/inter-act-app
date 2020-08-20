import { Component, OnInit } from '@angular/core';
import { UserService } from '../../services/user.service';
import { RoleService } from '../../services/role.service';

@Component({
  selector: 'app-manage-plataform',
  templateUrl: './manage-plataform.page.html',
  styleUrls: ['./manage-plataform.page.scss'],
})
export class ManagePlataformPage implements OnInit {
  public allUsers = [];

  constructor(public userService:UserService, public roleService:RoleService) { }

  ngOnInit() { }

  //Chamada das funcoes para quando o usuario entrar na pagina
  public ionViewWillEnter() {
    this.indexAllUsers();
  }

  //Lista todos os usuarios registrados na plataforma
  public indexAllUsers() {
    this.userService.indexAllUsers().subscribe((response) => {
      this.allUsers = response.users;
      this.isModerator(this.allUsers);
    });
  }

  //Recebe o id de um usuario e o deleta
  public destroyUser(user_id) {
    this.userService.destroyUser(user_id).subscribe((response) => {
      console.log(response.message);
      this.indexAllUsers();
    });
  }

  //Moderador adiciona um marcador de moderador a outro usuario da plataforma
  public assignModerator(user_id) {
    this.roleService.assignModerator(user_id).subscribe((response) => {
      console.log(response.message);
      this.indexAllUsers();
    });
  }

  public isModerator(users) {
    for(let i=0; i<users.length; i++) {
      this.roleService.isModerator(users[i].id).subscribe((response) => {
        users[i].isMod = response;
      });
    }
    console.log(this.allUsers);
  }

  //Acao do botao de voltar na header
  goBack() {
    window.history.back();
  }
}
