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
        role: this.getRoleName(res.user.id_role) // fonction utilitaire pour transformer id_role en nom
      };

      this.authService.saveUser(user);

      // Redirection selon le rôle
      if (user.role === 'Admin') {
        this.router.navigate(['/admin/gestion-admin']);
      } else if (user.role === 'Enseignant' || user.role === 'Etudiant') {
        this.router.navigate(['/user/gestion-reservation']);
      } else {
        this.router.navigate([this.returnUrl]);
      }
    },
    error: (err) => {
      console.error(err);
      this.message = 'Email ou mot de passe incorrect';
    }
  });
}

/**
 * Transforme l'id_role en nom de rôle
 */
private getRoleName(roleId: number): string {
  switch (roleId) {
    case 1: return 'Admin';
    case 2: return 'Enseignant';
    case 3: return 'Etudiant';
    default: return 'Utilisateur';
  }
}



}
