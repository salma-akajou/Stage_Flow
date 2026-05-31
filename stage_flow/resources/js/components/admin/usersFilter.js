export default (routeIndex = '', initialSearch = '', initialRole = '', initialStatut = '') => ({
    init() {
        this.dispatchFilter();
    },
    search: initialSearch,
    role: initialRole,
    statut: initialStatut,
    loading: false,
    dispatchFilter() {
        window.dispatchEvent(new CustomEvent('users-filter-changed', {
            detail: { search: this.search, role: this.role, statut: this.statut }
        }));
    },
    submit() {
        this.loading = true;
        this.dispatchFilter();
        const params = new URLSearchParams({
            search: this.search,
            role: this.role,
            statut: this.statut
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
