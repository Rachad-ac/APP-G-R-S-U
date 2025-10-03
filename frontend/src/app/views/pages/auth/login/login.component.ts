import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { AuthService } from 'src/app/services/auth/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  returnUrl: any;
  message : string = '';

  constructor(private router: Router, private route: ActivatedRoute , private authService: AuthService) { }

  ngOnInit(): void {
    this.returnUrl = this.route.snapshot.queryParams['returnUrl'] || '/admin/gestion-admin';
  }

onLoggedin(e: Event, formValues: { email: string, password: string }) {
  e.preventDefault();

  if (!formValues.email || !formValues.password) {
    this.message = 'Veuillez remplir tous les champs.';
    return;
  }

  this.authService.login(formValues).subscribe({
    next: (res: any) => {
      // Stocker le token
      this.authService.saveToken(res.token);

      // Construire un objet user avec role lisible
      const user = {
        id: res.user.id,
        nom: res.user.nom,
        prenom: res.user.prenom,
        email: res.user.email,
        roleId: res.user.id_role,
        role: res.user.role
      };

      this.authService.saveUser(user);

      // Redirection selon le rôle
      if (user.role === 'Admin') {
          this.router.navigate(['/admin/gestion-admin']);
        } else if (user.role === 'Etudiant') {
          this.router.navigate(['/etudiant/gestion-users']);
        } else if (user.role === 'Enseignant') {
          this.router.navigate(['/enseignant/gestion-users']);
        } else {
          this.router.navigate(['/error']);
      }

    },
    error: (err) => {
      console.error(err);
      this.message = 'Email ou mot de passe incorrect';
    }
  });
}
}
