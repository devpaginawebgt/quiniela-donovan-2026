import './bootstrap';
import 'flowbite';
import { initToastErrors } from './components/toast-errors';

document.addEventListener('DOMContentLoaded', () => {
    initToastErrors();
});

import Swiper from 'swiper';
import { Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

Swiper.use([Autoplay, Pagination]);
window.Swiper = Swiper;