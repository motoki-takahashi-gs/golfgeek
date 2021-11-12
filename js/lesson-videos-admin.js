import { AddVideoModal } from "./classes/AddVideoModal.js";
import { AddVideoRequest } from "./classes/AddVideoRequest.js";
import { EditVideoRequest } from "./classes/EditVideoRequest.js";
import { DeleteVideoModal } from "./classes/DeleteVideoModal.js";
import { DeleteVideoRequest } from "./classes/DeleteVideoRequest.js";
import { MobileMenu } from "./classes/MobileMenu.js";

const addVideoModal = new AddVideoModal(
    'open-add-video-modal',
    'add-video-modal'
);

const addVideoRequest = new AddVideoRequest(
    'add-video-form',
    'add-this-video',
    'add-video-complete-modal',
    './includes/add-video-process.php'
);

const editVideoRequest = new EditVideoRequest(
    'edit-videos-form',
    'save-video-settings',
    '',
    './includes/edit-videos-process.php'
);

const deleteVideoModal = new DeleteVideoModal(
    'delete',
    'delete-video-modal'
);

const deleteVideoRequest = new DeleteVideoRequest(
    'delete-video-form',
    'delete-this-video',
    '',
    './includes/delete-video-process.php'
);

const mobileMenu = new MobileMenu();