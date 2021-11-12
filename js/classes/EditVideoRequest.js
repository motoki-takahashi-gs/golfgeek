import { HttpRequest } from "./HttpRequest.js";

export class EditVideoRequest extends HttpRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl) {
        super(formId, submitButtonId, completeModalId, requestUrl);
    }

    showSuccess() {
        window.location.href = document.referrer;
    }

    showError(errorObj) {
        const errorObjKeys = Object.keys(errorObj);
        let keyName = '';

        // loop with the number of object's keys
        for (let i = 0; i < errorObjKeys.length; i++) {

            // when the value of object is an array
            if (typeof errorObj[errorObjKeys[i]] == 'object') {
                keyName = errorObjKeys[i];

            } else if (typeof errorObj[errorObjKeys[i]] == 'string') {

                // put an error message to each item
                for (let j = 0; j < errorObj[keyName].length; j++) {
                    document.getElementsByClassName(errorObjKeys[i] + '-error')[errorObj[keyName][j]].innerText = errorObj[errorObjKeys[i]];
                }
            }
        }
    }
}