export class Navigation {

    constructor() {
        this.backButton = document.getElementById('go-back');
        if (this.backButton) this.backButton.addEventListener('click', () => this.goBack());
    }

    goBack() {
        document.referrer == '' ? window.location.href = './index.php' : window.history.back();
    }
}