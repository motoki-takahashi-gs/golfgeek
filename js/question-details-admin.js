import { Navigation } from "./classes/Navigation.js";
import { AdviseModal } from "./classes/AdviseModal.js";
import { AttachImage } from "./classes/AttachImage.js";
import { Advise } from "./classes/Advise.js";
import { MobileMenu } from "./classes/MobileMenu.js";

const navigation = new Navigation();

const adviseModal = new AdviseModal(
    'open-advice',
    'advise-modal'
);

const attachImage = new AttachImage();

const advise = new Advise(
    'advise-form',
    'advise',
    'advise-complete-modal',
    './includes/sos-process.php?user_type=teaching_pros',
    adviseModal.toggleModalMethod
);

const mobileMenu = new MobileMenu();