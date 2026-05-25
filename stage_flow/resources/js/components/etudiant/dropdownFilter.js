export default (initialOpen = false) => ({
    open: initialOpen,
    toggle() {
        this.open = !this.open;
    },
    close() {
        this.open = false;
    }
});
