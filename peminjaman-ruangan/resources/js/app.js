import './bootstrap';

import Alpine from 'alpinejs';
import roomsPage from './rooms';
import loansPage from './loans';   // <— tambah

window.Alpine = Alpine;
window.roomsPage = roomsPage;
window.loansPage = loansPage;      // <— expose

Alpine.start();
