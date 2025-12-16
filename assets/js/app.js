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

    // Админские формы с классом .js-ajax-admin
    document.querySelectorAll('form.js-ajax-admin').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var fallbackTargetId = form.getAttribute('data-target');
            sendAjaxForm(form, function (data) {
                var targetId = data.targetId || fallbackTargetId;
                if (data.html && targetId) {
                    var target = document.getElementById(targetId);
                    if (target) {
                        target.innerHTML = data.html;
                    }
                } else if (data && data.success) {
                    var action = form.getAttribute('action') || '';

                    // Обновление статуса кейса прямо в таблице
                    if (action.indexOf('admin/case/status') !== -1) {
                        var row = form.closest('tr');
                        if (row) {
                            var cells = row.querySelectorAll('td');
                            // в разметке статус находится в 4-м столбце
                            var statusCell = cells[3];
                            var select = form.querySelector('select[name="status"]');
                            if (statusCell && select) {
                                var selectedOption = select.options[select.selectedIndex];
                                statusCell.textContent = selectedOption ? selectedOption.textContent : select.value;
                            }
                        }
                    }

                    // Обновление роли пользователя в таблице пользователей
                    if (action.indexOf('admin/user/role') !== -1) {
                        var rowUser = form.closest('tr');
                        if (rowUser) {
                            var userCells = rowUser.querySelectorAll('td');
                            // в разметке роль находится в 4-м столбце
                            var roleCell = userCells[3];
                            var roleSelect = form.querySelector('select[name="role"]');
                            if (roleCell && roleSelect) {
                                var selectedRole = roleSelect.options[roleSelect.selectedIndex];
                                roleCell.textContent = selectedRole ? selectedRole.textContent : roleSelect.value;
                            }
                        }
                    }
                }
            }, function () {
                // при ошибке пока ничего не делаем
            });
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
