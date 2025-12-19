<div class="page-header">
    <div class="page-header-icon"></div>
    <div class="page-header-text">
        <h1>Личный кабинет</h1>
        <?php if (!empty($user)): ?>
            <small>USACitizenGuide - ваш помощник в получении гражданства США</small>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($user)): ?>
    <div class="profile-container">
        <div class="profile-header">
            <div class="avatar-section">
                <?php if (!empty($user['avatar'])): ?>
                    <img src="/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Аватар" class="profile-avatar" id="profileAvatar">
                <?php else: ?>
                    <div class="profile-avatar placeholder" id="profileAvatar">
                        <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                <button type="button" class="btn btn-small" onclick="showAvatarUpload()">Изменить аватар</button>
            </div>
            <div class="profile-info">
                <h2 id="profileName"><?php echo htmlspecialchars($user['name']); ?></h2>
                <p><?php echo htmlspecialchars($user['email']); ?></p>
                <button type="button" class="btn btn-small" onclick="showNameEdit()">Изменить имя</button>
            </div>
        </div>

        <!-- Avatar Upload Form (Hidden by default) -->
        <div id="avatarUploadForm" style="display: none;">
            <div class="card">
                <h3>Изменить аватар</h3>
                <form id="avatarForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="avatarInput">Выберите изображение:</label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*">
                        <small>Допустимые форматы: JPG, PNG, GIF. Максимальный размер: 2MB</small>
                    </div>
                    <div class="preview-container" id="avatarPreview" style="display: none;">
                        <p>Предпросмотр:</p>
                        <div class="preview-avatar"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn">Сохранить аватар</button>
                        <button type="button" class="btn btn-secondary" onclick="hideAvatarUpload()">Отмена</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Name Edit Form (Hidden by default) -->
        <div id="nameEditForm" style="display: none;">
            <div class="card">
                <h3>Изменить имя</h3>
                <form id="nameForm">
                    <div class="form-group">
                        <label for="nameInput">Новое имя:</label>
                        <input type="text" name="name" id="nameInput" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn">Сохранить имя</button>
                        <button type="button" class="btn btn-secondary" onclick="hideNameEdit()">Отмена</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="profile-grid">
    <div class="card">
        <h2>Мои кейсы</h2>
        <p>Управляйте своими миграционными кейсами для разных способов получения гражданства.</p>
        <p><a href="index.php?route=case" class="btn btn-secondary">Перейти к кейсам</a></p>
    </div>

    <div class="card">
        <h2>Анкета (wizard)</h2>
        <p>Пройдите анкету, чтобы оценить свои исходные данные и возможный путь к гражданству.</p>
        <p><a href="index.php?route=wizard" class="btn btn-secondary">Открыть анкету</a></p>
    </div>

    <div class="card">
        <h2>Обратная связь</h2>
        <p>Отправьте отзыв или задайте вопрос о получении гражданства.</p>
        <p><a href="index.php?route=contact" class="btn btn-secondary">Перейти к форме</a></p>
    </div>
</div>

<style>
.profile-container {
    margin-bottom: 30px;
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}

.avatar-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #4a90e2;
}

.profile-avatar.placeholder {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #4a90e2;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: bold;
    border: 3px solid #4a90e2;
}

.profile-info h2 {
    margin: 0 0 5px 0;
    color: #333;
}

.profile-info p {
    margin: 0;
    color: #666;
}

.btn-small {
    padding: 5px 10px;
    font-size: 12px;
}

#avatarUploadForm {
    margin-bottom: 20px;
}

#avatarUploadForm .form-group {
    margin-bottom: 15px;
}

#avatarUploadForm label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

#avatarUploadForm input[type="file"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

#avatarUploadForm small {
    display: block;
    margin-top: 5px;
    color: #666;
}

.preview-container {
    margin: 15px 0;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    text-align: center;
}

.preview-container p {
    margin: 0 0 10px 0;
    font-weight: 500;
    color: #666;
}

.preview-avatar {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #4a90e2;
}

.preview-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.form-actions .btn {
    flex: 1;
}

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
function showAvatarUpload() {
    document.getElementById('avatarUploadForm').style.display = 'block';
    document.getElementById('nameEditForm').style.display = 'none';
}

function hideAvatarUpload() {
    document.getElementById('avatarUploadForm').style.display = 'none';
    document.getElementById('avatarForm').reset();
    // Скрываем и очищаем предпросмотр
    const previewContainer = document.getElementById('avatarPreview');
    if (previewContainer) {
        previewContainer.style.display = 'none';
        previewContainer.querySelector('.preview-avatar').innerHTML = '';
    }
}

function showNameEdit() {
    document.getElementById('nameEditForm').style.display = 'block';
    document.getElementById('avatarUploadForm').style.display = 'none';
}

function hideNameEdit() {
    document.getElementById('nameEditForm').style.display = 'none';
    document.getElementById('nameForm').reset();
}

function showNotification(message, type = 'success') {
    // Создаем уведомление
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'success' ? '#28a745' : '#dc3545'};
        color: white;
        border-radius: 5px;
        z-index: 9999;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: opacity 0.3s;
    `;
    
    document.body.appendChild(notification);
    
    // Автоматически скрыть через 3 секунды
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    // Avatar upload
    const avatarForm = document.getElementById('avatarForm');
    if (avatarForm) {
        avatarForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Сохранение...';
            
            fetch('/index.php?route=user/updateProfile', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Аватар успешно обновлен!');
                    
                    // Обновляем аватар на странице только после успешного сохранения
                    if (data.avatar) {
                        const profileAvatar = document.getElementById('profileAvatar');
                        if (profileAvatar.tagName === 'IMG') {
                            profileAvatar.src = '/' + data.avatar + '?t=' + Date.now();
                        } else {
                            // Заменяем div на img
                            const img = document.createElement('img');
                            img.src = '/' + data.avatar + '?t=' + Date.now();
                            img.alt = 'Аватар';
                            img.className = 'profile-avatar';
                            img.id = 'profileAvatar';
                            profileAvatar.replaceWith(img);
                        }
                        
                        // Обновляем аватар в навигации
                        const navAvatar = document.querySelector('.user-avatar-nav img');
                        if (navAvatar) {
                            navAvatar.src = '/' + data.avatar + '?t=' + Date.now();
                        } else {
                            const navPlaceholder = document.querySelector('.avatar-placeholder-nav');
                            if (navPlaceholder) {
                                const img = document.createElement('img');
                                img.src = '/' + data.avatar + '?t=' + Date.now();
                                img.alt = 'Аватар';
                                navPlaceholder.replaceWith(img);
                            }
                        }
                    }
                    
                    hideAvatarUpload();
                } else {
                    showNotification(data.message || 'Ошибка при загрузке аватара', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Произошла ошибка при загрузке', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Сохранить аватар';
            });
        });
    }
    
    // Name edit
    const nameForm = document.getElementById('nameForm');
    if (nameForm) {
        nameForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Сохранение...';
            
            fetch('/index.php?route=user/updateProfile', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Имя успешно обновлено!');
                    
                    // Обновляем имя на странице только после успешного сохранения
                    const newName = formData.get('name');
                    const profileName = document.getElementById('profileName');
                    profileName.textContent = newName;
                    
                    // Обновляем имя в навигации
                    const navName = document.querySelector('.user-dropdown a');
                    if (navName) {
                        navName.textContent = newName;
                    }
                    
                    // Обновляем placeholder аватара если нет аватара
                    const avatarPlaceholder = document.querySelector('.profile-avatar.placeholder');
                    if (avatarPlaceholder) {
                        avatarPlaceholder.textContent = newName.charAt(0).toUpperCase();
                    }
                    
                    hideNameEdit();
                } else {
                    showNotification(data.message || 'Ошибка при обновлении имени', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Произошла ошибка при сохранении', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Сохранить имя';
            });
        });
    }
    
    // Preview avatar ONLY in preview container, not in main profile
    const avatarInput = document.getElementById('avatarInput');
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                
                // Проверка размера файла (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('Размер файла не должен превышать 2MB', 'error');
                    this.value = '';
                    return;
                }
                
                // Показываем контейнер предпросмотра
                const previewContainer = document.getElementById('avatarPreview');
                const previewAvatar = previewContainer.querySelector('.preview-avatar');
                
                // Предпросмотр только в контейнере предпросмотра
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewAvatar.innerHTML = '<img src="' + e.target.result + '" alt="Предпросмотр аватара">';
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
