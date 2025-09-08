import './bootstrap';

import Alpine from 'alpinejs';
import roomsPage from './rooms';
import loansPage from './loans';
import schedulePage from './schedule'; 
import manageUsersPage from './manage_users';

window.Alpine = Alpine;
window.roomsPage = roomsPage;
window.loansPage = loansPage;
window.schedulePage = schedulePage;      // <— expose
window.manageUsersPage = manageUsersPage; // <— expose

Alpine.start();
