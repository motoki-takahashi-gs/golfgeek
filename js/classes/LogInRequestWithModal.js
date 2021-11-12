import { LogInRequest } from "./LogInRequest.js";

export class LogInRequestWithModal extends LogInRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl, toggleLogInModal, openLogInModalButton, toggleSosModal) {
        super(formId, submitButtonId, completeModalId, requestUrl);
        this.toggleLogInModal = toggleLogInModal;
        this.openLogInModalButton = openLogInModalButton;
        this.toggleSosModal = toggleSosModal;
    }

    showSuccess() {
        this.toggleLogInModal();
        this.openLogInModalButton.removeEventListener('click', this.toggleLogInModal);
        this.openLogInModalButton.addEventListener('click', () => this.toggleSosModal());
        setTimeout(() => this.openLogInModalButton.click(), this.timeOut);
    }
}