export default (routeIndex = '') => ({
    search: '', 
    role: '',
    updateTable() {
        fetch(`${routeIndex}?search=${this.search}&role=${this.role}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            document.getElementById('feedbacks-table-container').innerHTML = html;
        });
    }
    
});
