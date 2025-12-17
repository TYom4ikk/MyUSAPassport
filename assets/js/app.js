document.addEventListener('DOMContentLoaded', function () {
    function isAjaxSupported() {
        return window.fetch && window.FormData;
    }

    if (!isAjaxSupported()) {
        return;
    }

    function sendAjaxForm(form, onSuccess, onError) {
        var action = form.getAttribute('action') || window.location.href;
        var method = (form.getAttribute('method') || 'GET').toUpperCase();
        var formData = new FormData(form);

        fetch(action, {
            method: method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function (resp) {
            return resp.json();
        }).then(function (data) {
            if (data && data.success) {
                if (onSuccess) onSuccess(data);
            } else {
                if (onError) onError(data || {success: false});
            }
        }).catch(function (err) {
            if (onError) onError({success: false, error: err});
        });

    // Универсальные формы с классом .js-ajax
    document.querySelectorAll('form.js-ajax').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var fallbackTargetId = form.getAttribute('data-target');
            var messageTargetId = form.getAttribute('data-message-target');

            sendAjaxForm(form, function (data) {
                var targetId = data.targetId || fallbackTargetId;
                if (data.html && targetId) {
                    var target = document.getElementById(targetId);
                    if (target) {
                        target.innerHTML = data.html;
                    }
                }
                if (data.message) {
                    var msgId = data.messageTarget || messageTargetId;
                    if (msgId) {
                        var msgEl = document.getElementById(msgId);
                        if (msgEl) {
                            msgEl.textContent = data.message;
                        }
                    }
                }
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            }, function () {
                // при ошибке пока ничего не делаем
            });
        });
    });
    }

    // Админские формы с классом .js-ajax-admin - используем делегирование событий
    document.addEventListener('submit', function(e) {
        var form = e.target.closest('form.js-ajax-admin');
        if (!form) return;
        
        e.preventDefault();
        
        var action = form.getAttribute('action') || '';
        console.log('Admin form submitted:', action); // Отладка
        
        // Блокируем кнопку только для форм УДАЛЕНИЯ
        var isDeleteForm = action.indexOf('/delete') !== -1;
        var submitBtn = form.querySelector('button[type="submit"]');
        
        if (isDeleteForm && submitBtn && submitBtn.disabled) {
            console.log('Delete form already submitting, ignoring...');
            return;
        }
        
        if (isDeleteForm && submitBtn) {
            submitBtn.disabled = true;
            submitBtn.textContent = 'Удаление...';
        }
        
        var fallbackTargetId = form.getAttribute('data-target');
        sendAjaxForm(form, function (data) {
            console.log('Admin form success:', data); // Отладка
            var targetId = data.targetId || fallbackTargetId;
            if (data.html && targetId) {
                var target = document.getElementById(targetId);
                if (target) {
                    target.innerHTML = data.html;
                    console.log('Content updated for:', targetId); // Отладка
                }
            }
            
            // Очищаем поля формы для создания (не для удаления)
            if (!isDeleteForm) {
                console.log('Clearing form fields...'); // Отладка
                var titleInput = form.querySelector('input[name="title"]');
                console.log('Title input found:', !!titleInput); // Отладка
                if (titleInput) titleInput.value = '';
                var contentTextarea = form.querySelector('textarea[name="content"]');
                console.log('Content textarea found:', !!contentTextarea); // Отладка
                if (contentTextarea) contentTextarea.value = '';
                var questionInput = form.querySelector('input[name="question"]');
                if (questionInput) questionInput.value = '';
                var answerTextarea = form.querySelector('textarea[name="answer"]');
                if (answerTextarea) answerTextarea.value = '';
                var fileInput = form.querySelector('input[type="file"]');
                if (fileInput) fileInput.value = '';
            } else {
                console.log('Delete form, not clearing fields'); // Отладка
            }
        }, function (error) {
            console.log('Admin form error:', error); // Отладка
            // Разблокируем кнопку только для форм удаления
            if (isDeleteForm && submitBtn) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Удалить';
            }
        });
    });

    // Пример: форма обратной связи с id contact-form
    var contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            sendAjaxForm(contactForm, function (data) {
                var msg = document.getElementById('contact-form-message');
                if (msg) {
                    msg.textContent = data.message || 'Сообщение отправлено.';
                }
                contactForm.reset();
            }, function (data) {
                var msg = document.getElementById('contact-form-message');
                if (msg) {
                    msg.textContent = (data && data.message) || 'Ошибка при отправке.';
                }
            });
        });
    }
});
