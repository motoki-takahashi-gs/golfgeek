export class HttpRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl) {
        this.formErrorArray = document.querySelectorAll('#' + formId + ' .form-error');
        this.submitButton = document.getElementById(submitButtonId);
        this.completeModal = document.getElementById(completeModalId);
        if (this.completeModal) this.closeMark = this.completeModal.getElementsByClassName('close')[0];
        this.xhr = new XMLHttpRequest();
        this.timeOut = 500;
        if (this.submitButton) this.submitButton.addEventListener('click',
            () => this.sendRequest(requestUrl, formId));
        if (this.closeMark) this.closeMark.addEventListener('click', () => this.toggleCompleteModal());
        this.xhr.addEventListener('load', () => this.getResponse());
    }

    containsStringInUrl(string) {
        return window.location.href.includes(string);
    }

    isJson() {
        try {
            JSON.parse(this.xhr.response);
        } catch (error) {
            return false;
        }
        return true;
    }

    sendRequest(url, formId) {
        const form = document.getElementById(formId);
        const formData = new FormData(form);
        const requestUrl = (this.containsStringInUrl('/admin/')) ? '.' + url : url;
        this.xhr.open('POST', requestUrl, true);
        this.xhr.send(formData);
    }

    getResponse() {
        if (this.xhr.status == 200) {
            for (let i = 0; i < this.formErrorArray.length; i++) {
                this.formErrorArray[i].innerText = '';
            }
            // when response is successful
            if (this.xhr.response == 'success') {
                this.showSuccess();
            } else {
                // when response is JSON format
                if (this.isJson()) {
                    console.log(this.xhr.response);
                    const errorObj = JSON.parse(this.xhr.response);
                    this.showError(errorObj);
                } else {
                    // when response is PHP/SQL error
                    console.log(this.xhr.response);
                }
            }
        }
    }

    reloadPage() {
        location.reload();
    }

    showSuccess() {
        this.toggleCompleteModal();
        setTimeout(() => this.reloadPage(), this.timeOut * 3);
    }

    showError(errorObj) {
        const errorObjKeys = Object.keys(errorObj);
        for (let i = 0; i < errorObjKeys.length; i++) {
            document.getElementById(errorObjKeys[i] + '-error').innerText = errorObj[errorObjKeys[i]];
        }
    }

    toggleCompleteModal() {
        this.completeModal.classList.toggle('modal-active');
    }
}