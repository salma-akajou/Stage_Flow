export default (initialUrl = '') => ({
    photoUrl: initialUrl,
    photoName: '',
    updatePhoto(event) {
        const file = event.target.files[0];
        if (file) {
            this.photoUrl = URL.createObjectURL(file);
            this.photoName = file.name;
        }
    }
});
