(function() {
    document.addEventListener('click', e => {
        const btn = e.target.closest('.review__save-button');
        if(!btn) return;

        const reviewId = btn.dataset.reviewId;

        fetch('/api/saved', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `review_id=${reviewId}&csrf_token=${window.CSRF_TOKEN}`
        })
        .then(res => res.json())
        .then(data => {
            if(data.saved !== undefined) {
                btn.classList.toggle('saved', data.saved);
                btn.querySelector('span').textContent = data.saved
                    ? 'bookmark_added'
                    : 'bookmark';
            }
        });
    });
})();