import './bootstrap';

import Alpine from 'alpinejs';
import roomsPage from './rooms';   // <— import komponen halaman rooms

window.Alpine = Alpine;
window.roomsPage = roomsPage;      // <— expose supaya bisa dipakai: x-data="roomsPage()"

Alpine.start();                    // <— start terakhir
