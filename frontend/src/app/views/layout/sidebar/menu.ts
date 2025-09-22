import { MenuItem } from './menu.model';

// Définition du menu latéral de l'application
export const MENU: MenuItem[] = [
  // Section gestion admin
  {
    label: 'Gestion Administrateur',
    isTitle: true,
  },
  {
    label: 'Utilisateurs',
    icon: 'users',
    link: '/admin/gestion-admin/users'
  },

  // Section gestion resevation
  {
    label: 'Gestion Reservation',
    isTitle: true,
  },
  
];
