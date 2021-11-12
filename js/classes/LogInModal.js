import { Modal } from "./Modal.js";

export class LogInModal extends Modal {

    constructor(openModalButtonId, modalId, openAnotherModalButtonId, anotherModalId) {
        super(openModalButtonId, modalId);
        this.openAnotherModalText = document.getElementById(openAnotherModalButtonId);
        this.anotherModal = document.getElementById(anotherModalId);
        if (this.openAnotherModalText)
            this.openAnotherModalText.addEventListener('click', () => this.changeModal());
    }

    showForm(contentClass) {
        this.modal.classList.remove('modal');
        const modalContent = document.getElementsByClassName(contentClass)[0];
        modalContent.classList.remove(contentClass);
    }

    removeNavigation(navigationClass) {
        const navigationDiv = document.getElementsByClassName(navigationClass)[0];
        navigationDiv.remove();
    }

    removeCloseMark() {
        this.closeMark.remove();
    }

    toggleAnotherModal() {
        this.anotherModal.classList.toggle('modal-active');
    }

    changeModal() {
        this.toggleModal();
        setTimeout(() => this.toggleAnotherModal(), 500);
    }
}