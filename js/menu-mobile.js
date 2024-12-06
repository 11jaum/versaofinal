// Mobile

function menuShow() {
    let menumobile = document.querySelector('.menu-mobile')
    if (menumobile.classList.contains('open')) {
        menumobile.classList.remove('open');
    }
    else {
        menumobile.classList.add('open');
    }
}