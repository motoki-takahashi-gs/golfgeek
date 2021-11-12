import { LogInModal } from "./LogInModal.js";

export class SignUpModal extends LogInModal {
    constructor(openModalButtonId, modalId, openAnotherModalButtonId, anotherModalId) {
        super(openModalButtonId, modalId, openAnotherModalButtonId, anotherModalId);
    }
}