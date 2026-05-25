export default (selected = '', options = []) => ({
    open: false,
    selected,
    options,
    select(opt) {
        this.selected = opt;
        this.open = false;
    }
});
