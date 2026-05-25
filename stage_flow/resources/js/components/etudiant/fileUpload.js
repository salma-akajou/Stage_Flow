export default () => ({
    fileName: '',
    updateFile(event) {
        this.fileName = event.target.files[0]?.name || '';
    }
});
