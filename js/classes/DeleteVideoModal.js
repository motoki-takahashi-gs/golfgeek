import { Modal } from "./Modal.js";

export class DeleteVideoModal extends Modal {

    constructor(openModalButtonClass, modalId) {
        super('', modalId);
        this.openModalButtons = document.getElementsByClassName(openModalButtonClass);
        if (this.openModalButtons) {
            for (let i = 0; i < this.openModalButtons.length; i++) {
                this.openModalButtons[i].addEventListener('click', (e) => {
                    this.toggleModal();
                    this.setVideoId(e);
                    this.setVideoName(e);
                });
            }
        }
    }

    setVideoId(e) {
        const nodes = e.target.parentNode.parentNode.childNodes;

        for (let i = 0; i < nodes.length; i++) {
            if (nodes[i].getAttribute('name') == 'video-id[]') {
                document.querySelector('#delete-video-form input[name="video-id"]').value = nodes[i].value;
            }
        }
    }

    setVideoName(e) {
        const element = e.target.parentNode.parentNode.querySelector('[name="video-title[]"]');
        document.getElementById('video-title').textContent = element.textContent;
    }
}