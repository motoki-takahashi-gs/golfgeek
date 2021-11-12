import { SignUpModal } from "./classes/SignUpModal.js";
import { LogInModal } from "./classes/LogInModal.js";
import { SosModal } from "./classes/SosModal.js";
import { SignUpRequestWithModal } from "./classes/SignUpRequestWithModal.js";
import { LogInRequestWithModal } from "./classes/LogInRequestWithModal.js";
import { AskQuestion } from "./classes/AskQuestion.js";
import { MobileMenu } from "./classes/MobileMenu.js";

const signUpModalId = 'sign-up-modal';
const logInModalId = 'log-in-modal';

const signUpModal = new SignUpModal(
    '',
    signUpModalId,
    'go-to-log-in',
    logInModalId
);

const logInModal = new LogInModal(
    'open-login',
    logInModalId,
    'go-to-sign-up',
    signUpModalId
);

const sosModal = new SosModal(
    'open-sos',
    'sos-modal'
);

const signUpRequestWithModal = new SignUpRequestWithModal(
    'signup-form',
    'submit-signup',
    'sign-up-complete-modal',
    './includes/sign-up-process.php',
    signUpModal.toggleModalMethod,
    logInModal.toggleModalMethod,
    logInModal.openModalButton,
    sosModal.toggleModalMethod
);

const logInRequestWithModal = new LogInRequestWithModal(
    'login-form',
    'submit-login',
    '',
    './includes/log-in-process.php',
    logInModal.toggleModalMethod,
    logInModal.openModalButton,
    sosModal.toggleModalMethod
);

const askQuestion = new AskQuestion(
    'sos-form',
    'ask-question',
    'sos-complete-modal',
    './includes/sos-process.php?user_type=golfers',
    sosModal.toggleModalMethod
);

const mobileMenu = new MobileMenu();