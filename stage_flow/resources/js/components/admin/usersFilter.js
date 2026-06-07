export default (routeIndex = '', initialSearch = '', initialRole = '') => ({
    init() {
        this.dispatchFilter();
    },
    search: initialSearch,
    role: initialRole,
    loading: false,
    dispatchFilter() {
        window.dispatchEvent(new CustomEvent('users-filter-changed', {
            detail: { search: this.search, role: this.role }
        }));
    },
    submit() {
        this.loading = true;
        this.dispatchFilter();
        const params = new URLSearchParams({
            search: this.search,
            role: this.role
        });
        
        fetch(routeIndex + '?' + params.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('users-table-container').innerHTML = html;
            this.loading = false;
        });
    }
});

