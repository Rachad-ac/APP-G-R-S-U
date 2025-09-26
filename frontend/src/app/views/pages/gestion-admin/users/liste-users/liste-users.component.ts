import { Component } from '@angular/core';
import { UserService } from 'src/app/services/user/user.service';
import { NgbModal } from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-liste-users',
  templateUrl: './liste-users.component.html',
  styleUrls: ['./liste-users.component.scss']
})
export class ListeUsersComponent {
  users: any[] = [];
  selectedUser: any;
  pageOptions = { page: 0, size: 10 };
  totalUsers = 0;

  constructor(private userService: UserService, private modalService: NgbModal) {}

  ngOnInit(): void {
    this.loadUsers();
  }

  // Chargement des utilisateurs avec pagination
  loadUsers() {
    this.userService.getUsers().subscribe({
      next: res => {
        console.log(`user ${res}`);
        this.users = res.payload;
        this.totalUsers = res.metadata?.totalElements || this.users.length;
      },
      error: err => console.error('Erreur lors du chargement des utilisateurs', err)
    });
  }

  // Pagination
  paginate(page: number) {
    this.pageOptions.page = page - 1;
    this.loadUsers();
  }

  // Modales
  openAddUserModal(modal: any) {
    this.modalService.open(modal, { size: 'lg' }).result.then(() => this.loadUsers());
  }

  openInfoUserModal(modal: any, user: any) {
    this.selectedUser = user;
    this.modalService.open(modal, { size: 'lg' });
  }

  openSearchUserModal(modal: any) {
    this.modalService.open(modal, { size: 'lg' });
  }
}
