import { LogInRequest } from "./LogInRequest.js";

export class SignUpRequest extends LogInRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl) {
        super(formId, submitButtonId, completeModalId, requestUrl);
    }

    showSuccess() {
        this.toggleCompleteModal();
        setTimeout(() => this.redirectToTopPage(), this.timeOut * 3);
    }
}