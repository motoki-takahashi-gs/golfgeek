import { HttpRequest } from "./HttpRequest.js";

export class Advise extends HttpRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl, toggleAdviseModal) {
        super(formId, submitButtonId, completeModalId, requestUrl);
        this.toggleAdviseModal = toggleAdviseModal;
    }

    showSuccess() {
        this.toggleAdviseModal();
        setTimeout(() => this.toggleCompleteModal(), this.timeOut);
        setTimeout(() => this.reloadPage(), this.timeOut * 4);
    }
}