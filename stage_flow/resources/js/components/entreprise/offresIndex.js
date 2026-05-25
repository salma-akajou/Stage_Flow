export default () => ({
    init() {
        document.addEventListener('click', (e) => {
            const link = e.target.closest('#table-container nav a');
            if (link) {
                e.preventDefault();
                window.fetchOffers(link.href);
            }
        });
    }
});

window.fetchOffers = function(url = null) {
    const container = document.getElementById('table-content');
    const form = document.getElementById('search-form');
    if (!form || !container) return;
    
    const fetchUrl = url || `${form.action}?${new URLSearchParams(new FormData(form)).toString()}`;

    fetch(fetchUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(res => res.text())
    .then(html => {
        container.innerHTML = html;
        if (typeof AOS !== 'undefined') AOS.refresh();
    });
};
