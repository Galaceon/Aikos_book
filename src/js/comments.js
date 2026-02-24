(function() {

    const replyButtons = document.querySelectorAll('.comment__reply-btn');

    if(replyButtons) {


            replyButtons.forEach(button => {

            button.addEventListener('click', function() {

                const commentId = this.dataset.commentId;
                const commentDiv = this.closest('.comment');

                // Evitar múltiples formularios abiertos
                const existingForm = commentDiv.querySelector('.dynamic-reply-form');
                if(existingForm) {
                    existingForm.remove();
                    return;
                }

                // Crear formulario
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/comment/create';
                form.classList.add('dynamic-reply-form');

                // review_id
                const reviewInput = document.createElement('input');
                reviewInput.type = 'hidden';
                reviewInput.name = 'review_id';
                reviewInput.value = document.querySelector('input[name="review_id"]').value;

                // parent_id
                const parentInput = document.createElement('input');
                parentInput.type = 'hidden';
                parentInput.name = 'parent_id';
                parentInput.value = commentId;

                // textarea
                const textarea = document.createElement('textarea');
                textarea.name = 'content';
                textarea.placeholder = 'Escribe tu respuesta...';
                textarea.required = true;
                textarea.classList.add('comment__textarea-response')

                // botón
                const submitBtn = document.createElement('button');
                submitBtn.type = 'submit';
                submitBtn.classList.add('comment__reply-submit-btn')
                submitBtn.textContent = 'Responder';

                // Añadir elementos al form
                form.appendChild(reviewInput);
                form.appendChild(parentInput);
                form.appendChild(textarea);
                form.appendChild(submitBtn);

                // Insertar debajo del comentario
                commentDiv.appendChild(form);

                textarea.focus();
            });

        });
    }


})();