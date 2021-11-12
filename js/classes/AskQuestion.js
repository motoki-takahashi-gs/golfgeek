import { HttpRequest } from "./HttpRequest.js";
import { AttachImage } from "./AttachImage.js";

export class AskQuestion extends HttpRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl, toggleSosModal) {
        super(formId, submitButtonId, completeModalId, requestUrl);
        this.description = document.querySelector('#' + formId + ' textarea[name=description]');
        this.attachImage = new AttachImage();
        this.toggleSosModal = toggleSosModal;
    }

    initializeDescription() {
        this.description.value = '';
    }

    showSuccess() {
        this.toggleSosModal();
        setTimeout(() => this.toggleCompleteModal(), this.timeOut);
        this.initializeDescription();
        this.attachImage.initializeRealButton();
        this.attachImage.initializeThumbnail();
    }
}