(function() {
    document.addEventListener('click', async e => {
        const likeBtn = e.target.closest('.review__like-button');
        if(!likeBtn) return;

        const reviewId = likeBtn.dataset.reviewId;

        const formData = new FormData();
        formData.append('review_id', reviewId);

        const response = await fetch('/api/likes', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if(data.error) return;

        likeBtn.classList.toggle('liked', data.liked);
        likeBtn.querySelector('.material-symbols-outlined').textContent =
            data.liked ? 'favorite' : 'favorite_border';

        likeBtn.querySelector('.review__like-count').textContent = data.total;
    });
})();