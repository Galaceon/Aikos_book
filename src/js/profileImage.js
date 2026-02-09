(function() {
    const inputAvatar = document.querySelector('#avatar');

    if(inputAvatar) {
        if(!inputAvatar) return;

        const avatarPreview = document.querySelector('#avatar-preview');

        inputAvatar.addEventListener('change', e => {
            const file = e.target.files[0];
            if (!file || !file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = () => {
                avatarPreview.src = reader.result;
            };
            reader.readAsDataURL(file);
        });
    }
})();