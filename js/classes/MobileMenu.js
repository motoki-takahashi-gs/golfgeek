export class MobileMenu {

    constructor() {
        this.hamburger = document.getElementById('hamburger');
        this.menu = document.getElementById('menu');
        if (this.hamburger) this.hamburger.addEventListener('click', () => this.toggle());
    }

    toggle() {
        this.hamburger.classList.toggle('active');
        this.menu.classList.toggle('active');
    }
}