import './bootstrap';

import Alpine from 'alpinejs';
import roomsPage from './rooms';
import loansPage from './loans';
import schedulePage from './schedule';   // <— tambah

window.Alpine = Alpine;
window.roomsPage = roomsPage;
window.loansPage = loansPage;
window.schedulePage = schedulePage;      // <— expose

Alpine.start();
