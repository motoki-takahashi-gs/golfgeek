import { SignUpModal } from "./classes/SignUpModal.js";
import { SignUpRequest } from "./classes/SignUpRequest.js";
import { MobileMenu } from "./classes/MobileMenu.js";

const signUpModal = new SignUpModal(
    '',
    'sign-up-modal'
);

signUpModal.showForm('modal-content-sign-up');
signUpModal.removeNavigation('go-to-log-in');
signUpModal.removeCloseMark();

const signUpRequest = new SignUpRequest(
    'signup-form',
    'submit-signup',
    'create-account-complete-modal',
    './includes/sign-up-process.php'
);

const mobileMenu = new MobileMenu();