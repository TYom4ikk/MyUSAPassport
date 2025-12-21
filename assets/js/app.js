document.addEventListener('DOMContentLoaded', function () {
    console.log('JavaScript loaded successfully'); // Отладка

    // Предотвращаем вывод JSON на экран
    var originalWrite = document.write;
    document.write = function(content) {
        if (content.startsWith('{') && content.includes('success')) {
            return; // Не выводим JSON-ответы
        }
        return originalWrite.call(document, content);
    };

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

        console.log('AJAX Request Details:');
        console.log('Action:', action);
        console.log('Method:', method);
        console.log('FormData:');
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        fetch(action, {
            method: method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function (resp) {
            console.log('Response status:', resp.status);
            console.log('Response headers:', resp.headers);
            
            // Проверяем, что это AJAX-запрос
            if (!resp.headers.get('Content-Type') || !resp.headers.get('Content-Type').includes('application/json')) {
                // Если не JSON, просто показываем ответ
                return resp.text().then(function(text) {
                    console.log('Response text:', text);
                    // Не выводим JSON на экран
                    if (text.startsWith('{')) {
                        return JSON.parse(text);
                    }
                    return {success: false, error: 'Invalid response'};
                });
            }
            return resp.json();
        }).then(function (data) {
            console.log('Parsed data:', data);
            if (data && data.success) {
                if (onSuccess) onSuccess(data);
            } else {
                if (onError) onError(data || {success: false});
            }
        }).catch(function (err) {
            console.error('AJAX Error:', err);
            console.error('Error details:', err.message, err.stack);
            if (onError) onError({success: false, error: err});
        });
    }

    // Универсальные формы с классом .js-ajax
    document.querySelectorAll('form.js-ajax').forEach(function (form) {
        console.log('Found js-ajax form:', form.getAttribute('action')); // Отладка
        form.addEventListener('submit', function (e) {
            console.log('Form submitted:', form.getAttribute('action')); // Отладка
            e.preventDefault();
            var fallbackTargetId = form.getAttribute('data-target');
            var messageTargetId = form.getAttribute('data-message-target');
            console.log('Form data targets:', {fallbackTargetId, messageTargetId}); // Отладка

            sendAjaxForm(form, function (data) {
                console.log('AJAX success response:', data); // Отладка
                var targetId = data.targetId || fallbackTargetId;
                console.log('Target ID:', targetId); // Отладка

                if (data.html && targetId) {
                    var target = document.getElementById(targetId);
                    console.log('Target element found:', !!target); // Отладка
                    console.log('Target element:', target); // Отладка

                    if (target) {
                        // Если это case-checklists-list или case-documents-list, заменяем все содержимое (как в статьях)
                        if (targetId === 'case-checklists-list' || targetId === 'case-documents-list') {
                            console.log('Replacing HTML in', targetId); // Отладка
                            console.log('HTML to set:', data.html); // Отладка
                            console.log('Current target innerHTML:', target.innerHTML); // Отладка

                            // Используем полную замену как в статьях
                            target.innerHTML = data.html;
                            
                            console.log('HTML replaced successfully'); // Отладка
                            console.log('New target innerHTML:', target.innerHTML); // Отладка
                        } else {
                            target.innerHTML = data.html;
                        }
                    } else {
                        console.error('Target element not found:', targetId);
                    }
                }

                // Очищаем поля формы для чек-листов и документов
                var titleInput = form.querySelector('input[name="title"]');
                if (titleInput) titleInput.value = '';
                var stepsTextarea = form.querySelector('textarea[name="steps"]');
                if (stepsTextarea) stepsTextarea.value = '';
                var stageInput = form.querySelector('input[name="stage"]');
                if (stageInput) stageInput.value = '';
                var fileInput = form.querySelector('input[type="file"]');
                if (fileInput) fileInput.value = '';
                
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
            }, function (error) {
                console.log('AJAX error:', error); // Отладка
            });
        });
    });

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
            
            // Для форм удаления - удаляем элемент со страницы
            if (isDeleteForm && data.success) {
                var userRow = form.closest('tr');
                if (userRow) {
                    userRow.remove();
                    console.log('User row removed from table');
                }
                
                // Также обрабатываем удаление кейсов (карточки)
                var caseCard = form.closest('.card');
                if (caseCard) {
                    caseCard.remove();
                    console.log('Case card removed from page');
                }
                
                // Обрабатываем удаление чек-листов
                var checklistCard = form.closest('.checklist-card');
                if (checklistCard) {
                    checklistCard.remove();
                    console.log('Checklist card removed from page');
                }
                
                // Обрабатываем удаление чек-листов в view кейса
                var checklistDiv = form.closest('.card');
                if (checklistDiv && !caseCard) {
                    checklistDiv.remove();
                    console.log('Checklist div removed from case view');
                }
                
                // Обрабатываем удаление документов
                var documentLi = form.closest('li');
                if (documentLi) {
                    documentLi.remove();
                    console.log('Document li removed from page');
                } else {
                    // Если не нашли li, пробуем найти карточку документа
                    var documentCard = form.closest('.card');
                    if (documentCard && documentCard.id !== 'case-documents-list') {
                        documentCard.remove();
                        console.log('Document card removed from page');
                    }
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