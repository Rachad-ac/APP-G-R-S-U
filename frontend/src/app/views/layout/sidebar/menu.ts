import { MenuItem } from './menu.model';

// Définition du menu latéral de l'application
export const MENU: MenuItem[] = [
  // Section gestion admin
  {
    label: 'Administration',
    isTitle: true,
  },
  {
    label: 'Dashboard',
    icon: 'users',
    link: '/admin/gestion-admin/users'
  },
  {
    label: 'Reservation',
    icon: 'users',
    link: '/admin/gestion-admin/reservation'
  },
  {
    label: 'Planning',
    icon: 'users',
    link: '/admin/gestion-admin/planning'
  },
  {
    label: 'Salles',
    icon: 'users',
    link: '/admin/gestion-admin/salles'
  },
  {
    label: 'Classes',
    icon: 'users',
    link: '/admin/gestion-admin/classes'
  },
  {
    label: 'Matiers',
    icon: 'users',
    link: '/admin/gestion-admin/matieres'
  },
  {
    label: 'Filieres',
    icon: 'users',
    link: '/admin/gestion-admin/filieres'
  },
  {
    label: 'Cours',
    icon: 'users',
    link: '/admin/gestion-admin/cours'
  },

  // Section gestion users
  {
    label: 'Gestion utilisateurs',
    isTitle: true,
  },
  {
    label: 'Reservation',
    icon: 'users',
    link: '/users/gestion-users/reservation'
  },
  {
    label: 'Mes reservation',
    icon: 'users',
    link: '/users/gestion-users/mes-eservation'
  },
  {
    label: 'Mes cours',
    icon: 'users',
    link: '/users/gestion-users/mes-cours'
  },
  {
    label: 'Mon programme',
    icon: 'users',
    link: '/users/gestion-users/mon-programme'
  },

  
];
