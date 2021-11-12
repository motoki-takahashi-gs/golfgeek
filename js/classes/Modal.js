export class Modal {

    constructor(openModalButtonId, modalId) {
        this.openModalButton = document.getElementById(openModalButtonId);
        this.modal = document.getElementById(modalId);
        if (this.modal) this.closeMark = this.modal.getElementsByClassName('close')[0];
        this.toggleModalMethod = this.toggleModal.bind(this);
        if (this.openModalButton) this.openModalButton.addEventListener('click', this.toggleModalMethod);
        if (this.closeMark) this.closeMark.addEventListener('click', () => this.toggleModal());
    }

    toggleModal() {
        this.modal.classList.toggle('modal-active');
    }
}