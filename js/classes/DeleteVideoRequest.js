import { EditVideoRequest } from "./EditVideoRequest.js";

export class DeleteVideoRequest extends EditVideoRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl) {
        super(formId, submitButtonId, completeModalId, requestUrl);
    }
}