import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth/auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  message: string = '';
  roles: any = [
    { value: 'Etudiant', label: 'Etudiant' },
    { value: 'Enseignant', label: 'Enseignant' },
  ];

  // modèle pour le formulaire
  registerData = {
    nom: '',
    prenom: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: null
  };

  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {}

  onRegister(e: Event) {
    e.preventDefault();

    // Vérification basique mot de passe
    if (this.registerData.password !== this.registerData.password_confirmation) {
      this.message = "Les mots de passe ne correspondent pas.";
      return;
    }

    this.authService.register(this.registerData).subscribe({
      next: (res) => {
        this.message = "Inscription réussie ! ";
      },
      error: (err) => {
        console.error(err);
        this.message = "Une erreur est survenue lors de l'inscription.";
      }
    });
  }
showRegisterModal : boolean = true;
closeRegisterModal() {
  this.showRegisterModal = false;
}
}