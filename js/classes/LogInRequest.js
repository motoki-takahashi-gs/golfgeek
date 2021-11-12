import { HttpRequest } from "./HttpRequest.js";

export class LogInRequest extends HttpRequest {

    constructor(formId, submitButtonId, completeModalId, requestUrl) {
        super(formId, submitButtonId, completeModalId, requestUrl);
        this.queryString = window.location.search;
    }

    redirectToTopPage() {
        window.location.replace('./index.php');
    }

    getRedirectURL() {
        const urlParams = new URLSearchParams(this.queryString);
        const pageName = urlParams.get('page-name');
        const id = urlParams.get('id');
        const redirectURL = './' + pageName + '.php?id=' + id;
        return redirectURL;
    }

    redirectToDetailPage() {
        window.location.replace(this.getRedirectURL());
    }

    showSuccess() {
        if (this.containsStringInUrl('/log-in.php')) {
            if (this.queryString) {
                this.redirectToDetailPage();
            } else {
                this.redirectToTopPage();
            }
        }

    }
}