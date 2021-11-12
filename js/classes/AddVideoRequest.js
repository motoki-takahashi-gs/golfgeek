import { HttpRequest } from "./HttpRequest.js";

export class AddVideoRequest extends HttpRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl) {
        super(formId, submitButtonId, completeModalId, requestUrl);
    }
}