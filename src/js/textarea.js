(function() {
    function initTinyMCE() {
        const textareaLabel = document.querySelector('#admin-form-textarea');
        if(!textareaLabel) {
            return;
        }
        
        const isDark = document.body.classList.contains('darkmode');

        tinymce.init({
            selector: '#content',
            height: 400,

            skin: isDark ? 'oxide-dark' : 'oxide',
            content_css: isDark ? 'dark' : 'default',

            menubar: 'edit insert format',
            menu: {
                edit: { title: 'Editar', items: 'undo redo | cut copy paste | selectall' },
                insert: { title: 'Insertar', items: 'link image media inserttable' },
                format: { title: 'Formato', items: 'bold italic underline | align | forecolor backcolor' },
            },

            content_style: `
                body {
                    font-size: 16px;
                    ${isDark ? 'background:#111; color:#eee;' : 'background:#fff; color:#111;'}
                }
            `
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        initTinyMCE();
    });
})();
