import { SignUpRequest } from "./SignUpRequest.js";

export class SignUpRequestWithModal extends SignUpRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl, toggleSignUpModal, toggleLogInModal, openLogInModalButton, toggleSosModal) {
        super(formId, submitButtonId, completeModalId, requestUrl);
        this.toggleSignUpModal = toggleSignUpModal;
        this.toggleLogInModal = toggleLogInModal;
        this.openLogInModalButton = openLogInModalButton;
        this.toggleSosModal = toggleSosModal;
    }

    showSuccess() {
        this.toggleSignUpModal();
        setTimeout(() => this.toggleCompleteModal(), this.timeOut);
        this.openLogInModalButton.removeEventListener('click', this.toggleLogInModal);
        this.openLogInModalButton.addEventListener('click', () => this.toggleSosModal());
    }
}