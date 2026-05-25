export default (selectedId = '', selectedNom = 'Choisir une ville', villes = []) => ({
    open: false,
    selectedId,
    selectedNom,
    villes,
    select(id, nom) {
        this.selectedId = id;
        this.selectedNom = nom;
        this.open = false;
    }
});
