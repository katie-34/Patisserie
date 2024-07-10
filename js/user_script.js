document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');

    // Sélectionner les éléments
    const profile = document.querySelector('.header .flex .profile-detail');
    const userBtn = document.querySelector('#user-btn');
    const searchForm = document.querySelector('.header .flex .search-form');
    const searchBtn = document.querySelector('#search-btn');
    const navbar = document.querySelector('.navbar');
    const menuBtn = document.querySelector('#menu-btn');

    // Vérifier si les éléments existent avant d'attacher des événements
    if (userBtn && profile) {
        console.log('User button and profile found');
        userBtn.onclick = () => {
            profile.classList.toggle('active');
            if (searchForm) {
                searchForm.classList.remove('active');
            }
        };
    } else {
        console.log('User button or profile not found');
    }

    if (searchBtn && searchForm) {
        console.log('Search button and search form found');
        searchBtn.onclick = () => {
            searchForm.classList.toggle('active');
            if (profile) {
                profile.classList.remove('active');
            }
        };
    } else {
        console.log('Search button or search form not found');
    }

    if (menuBtn && navbar) {
        console.log('Menu button and navbar found');
        menuBtn.onclick = () => {
            navbar.classList.toggle('active');
        };
    } else {
        console.log('Menu button or navbar not found');
    }
});















const imgBox =  document.querySelector('.slider-container');
const slides = document.getElementsByClassName('slideBox');
var i = 0;

function nextSlide(){
    slides[i].classList.remove('active');
    i = (i + 1)% slides.length;
    slides[i].classList.add('active');
}
function prevSlide(){
    slides[i].classList.remove('active');
    i = (i - 1 + slides.length) % slides.length;
    slides[i].classList.add('active');
}