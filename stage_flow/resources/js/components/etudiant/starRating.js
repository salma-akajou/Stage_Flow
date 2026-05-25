export default (initialRating = 5) => ({
    rating: initialRating,
    setRating(val) {
        this.rating = val;
    }
});
