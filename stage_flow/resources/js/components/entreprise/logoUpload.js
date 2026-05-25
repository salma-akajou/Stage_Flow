export default (initialUrl = '') => ({
    logoUrl: initialUrl,
    previewLogo(event) {
        const file = event.target.files[0];
        if (file) {
            this.logoUrl = URL.createObjectURL(file);
        }
    }
});
