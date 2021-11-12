export class AttachImage {

    constructor() {
        this.customButton = document.getElementById('custom-button');
        this.realButton = document.getElementById('real-button');
        this.imageThumbnail = document.getElementById('image-thumbnail');
        this.videos = document.getElementsByClassName('hidden-video');
        this.canvases = document.getElementsByClassName('canvas-video');

        if (this.canvases) {
            this.ctx = [];
            for (let i = 0; i < this.canvases.length; i++) {
                this.ctx.push(this.canvases[i].getContext('2d'));
            }
        }

        this.playPauseButtons = document.getElementsByClassName('play-pause-button');
        this.nowLoading = document.getElementById('now-loading');
        this.fileReader = new FileReader();

        if (this.customButton) {
            this.customButton.addEventListener('click', () => this.clickRealButton());
            this.realButton.addEventListener('change', (e) => this.readFile(e));
            this.fileReader.addEventListener('loadstart', () => this.showLoadingSign());
            this.fileReader.addEventListener('loadend', () => this.hideLoadingSign());
            this.fileReader.addEventListener('load', (e) => this.setFileToSrc(e));
        }

        // only when there are one or more video tags
        if (this.videos) {

            for (let i = 0; i < this.videos.length; i++) {

                // in case the loadedmetadata event occurs too fast
                if (this.videos[i].readyState >= 2) this.prepareVideo(i);
                this.videos[i].addEventListener('loadedmetadata', () => this.prepareVideo(i));

                // it doesn't work for iOS
                this.videos[i].addEventListener('canplay', () => this.showVideoThumbnail(i));

                this.videos[i].addEventListener('play', () => {
                    this.showVideo(i);
                    this.addPlayingClass(i);
                });

                this.videos[i].addEventListener('pause', () => this.removePlayingClass(i));

                this.playPauseButtons[i].addEventListener('click', () => {
                    this.videos[i].paused ? this.playVideo(i) : this.pauseVideo(i);
                });
            }
        }
    }

    clickRealButton() {
        this.realButton.click();
    }

    initializeRealButton() {
        this.realButton.value = '';
    }

    initializeThumbnail() {
        this.imageThumbnail.removeAttribute('src');
        this.imageThumbnail.classList.remove('active');
        this.videos[0].removeAttribute('src');
        this.canvases[0].removeAttribute('width');
        this.canvases[0].removeAttribute('height');
        this.canvases[0].classList.remove('active');
        this.playPauseButtons[0].classList.remove('active');
    }

    readFile(e) {
        this.initializeThumbnail();
        this.fileReader.readAsDataURL(e.target.files[0]);
    }

    showLoadingSign() {
        this.nowLoading.style.display = 'block';
    }

    hideLoadingSign() {
        this.nowLoading.removeAttribute('style');
    }

    setImageToSrc(e) {
        this.imageThumbnail.src = e.target.result;
        this.imageThumbnail.classList.add('active');
    }

    setVideoToSrc(e) {
        // in case the file is MOV which can be played only in Safari
        if (e.target.result.includes('video/quicktime')) {
            // convert the file to mp4
            this.fileUrl = e.target.result.replace('video/quicktime', 'video/mp4');
        } else {
            this.fileUrl = e.target.result;
        }
        this.videos[0].src = this.fileUrl;
    }

    setFileToSrc(e) {
        if (e.target.result.includes('data:image/')) {
            this.setImageToSrc(e);
        } else if (e.target.result.includes('data:video/')) {
            this.setVideoToSrc(e);
        }
    }

    setCanvasSize(i) {
        this.canvases[i].width = this.videos[i].videoWidth;
        this.canvases[i].height = this.videos[i].videoHeight;
    }

    showCanvas(i) {
        this.canvases[i].classList.add('active');
    }

    showPlayPauseButton(i) {
        this.playPauseButtons[i].classList.add('active');
    }

    setCurrentTime(i, time) {
        this.videos[i].currentTime = time;
    }

    showVideoThumbnail(i) {
        this.ctx[i].drawImage(this.videos[i], 0, 0, this.canvases[i].width, this.canvases[i].height);
    }

    prepareVideo(i) {
        this.setCanvasSize(i);
        this.showCanvas(i);
        this.showPlayPauseButton(i);
        this.setCurrentTime(i, 0.001);
    }

    addPlayingClass(i) {
        this.playPauseButtons[i].classList.add('playing');
    }

    removePlayingClass(i) {
        this.playPauseButtons[i].classList.remove('playing');
    }

    playVideo(i) {
        this.videos[i].play();
    }

    pauseVideo(i) {
        this.videos[i].pause();
    }

    showVideo(i) {
        setInterval(() => { this.showVideoThumbnail(i); }, 1000 / 60); // for videos with 60 FPS
    }
}