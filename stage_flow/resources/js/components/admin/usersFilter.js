export default (routeIndex = '', initialSearch = '', initialRole = '', initialStatut = '') => ({
    search: initialSearch,
    role: initialRole,
    statut: initialStatut,
    loading: false,
    submit() {
        this.loading = true;
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
