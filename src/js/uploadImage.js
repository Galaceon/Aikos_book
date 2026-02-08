(function() {
    const dropZone = document.querySelector('.upload-zone');
    const inputFile = document.querySelector('#imagen');
    const preview = document.querySelector('#preview-imagen');

    if(dropZone) {
        ['dragenter', 'dragover'].forEach(event => {
            dropZone.addEventListener(event, e => {
                e.preventDefault();
                dropZone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(event => {
            dropZone.addEventListener(event, e => {
                e.preventDefault();
                dropZone.classList.remove('dragover');
            });
        });

        dropZone.addEventListener('drop', e => {
            const file = e.dataTransfer.files[0];
            inputFile.files = e.dataTransfer.files;
            mostrarPreview(file);
        });

        inputFile.addEventListener('change', e => {
            const file = e.target.files[0];
            mostrarPreview(file);
        });

        function mostrarPreview(file) {
            if(!file || !file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = e => {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            };
            reader.readAsDataURL(file);
        }
    }
})();




