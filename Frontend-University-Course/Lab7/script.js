const stars = document.querySelectorAll('.star');
const ratingDisplay = document.getElementById('rating-display');
const resetBtn = document.getElementById('reset');
const submitBtn = document.getElementById('submit');
const comment = document.querySelector('textarea');
const confirmation = document.getElementById('confirmation');

let currentRating = 0;

stars.forEach(star => {
    star.addEventListener('click', () => {
        currentRating = parseInt(star.dataset.rating);
        updateStars();
        ratingDisplay.textContent = currentRating;
    });
});

resetBtn.addEventListener('click', () => {
    currentRating = 0;
    updateStars();
    ratingDisplay.textContent = '0';
    comment.value = '';
});

submitBtn.addEventListener('click', () => {
    confirmation.textContent = `Rating: ${currentRating}, Comment: ${comment.value}`;
    confirmation.style.display = 'block';
});

function updateStars() {
    stars.forEach(star => {
        star.classList.toggle('active', 
            parseInt(star.dataset.rating) <= currentRating
        );
    });
}