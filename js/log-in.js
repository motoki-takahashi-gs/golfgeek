import { LogInModal } from "./classes/LogInModal.js";
import { LogInRequest } from "./classes/LogInRequest.js";
import { MobileMenu } from "./classes/MobileMenu.js";

const logInModal = new LogInModal(
    '',
    'log-in-modal'
);

logInModal.showForm('modal-content-log-in');
logInModal.removeNavigation('go-to-sign-up');
logInModal.removeCloseMark();

const logInRequest = new LogInRequest(
    'login-form',
    'submit-login',
    '',
    './includes/log-in-process.php'
);

const mobileMenu = new MobileMenu();