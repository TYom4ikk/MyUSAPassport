<h1>Админ-панель</h1>
<p>Вы вошли как администратор.</p>

<div class="admin-nav">
    <a href="index.php?route=admin/users" class="btn btn-secondary">Управление пользователями</a>
    <a href="index.php?route=admin/documents" class="btn btn-secondary">Модерация документов</a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="card" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724;">
        <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="card" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24;">
        <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<h2>Статьи</h2>
<div class="card" style="margin-top:8px;">
    <h3>Создать статью</h3>
    <form method="post" action="index.php?route=admin/article/create" enctype="multipart/form-data" class="js-ajax-admin" data-target="admin-articles-list">
        <label>Заголовок:
            <input type="text" name="title">
        </label>
        <label>Обложка (изображение, необязательно):
            <input type="file" name="image" accept="image/*">
        </label>
        <label>Текст:
            <textarea name="content"></textarea>
        </label>
        <button type="submit" class="btn">Сохранить</button>
    </form>
    <h3 style="margin-top:10px;">Список статей</h3>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
        <span style="font-size:13px; color:#4b5563;">Существующие статьи.</span>
        <button type="button" class="btn btn-secondary admin-toggle" data-target="admin-articles-list">Свернуть / развернуть</button>
    </div>
    <div id="admin-articles-list" class="admin-scroll">
        <?php if (!empty($articles)): ?>
            <ul>
                <?php foreach ($articles as $a): ?>
                    <li>
                        <?php echo htmlspecialchars($a['title']); ?>
                        <small>(<?php echo htmlspecialchars($a['created_at']); ?>)</small>
                        <form method="post" action="index.php?route=admin/article/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;" data-target="admin-articles-list">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($a['id']); ?>">
                            <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Статей пока нет.</p>
        <?php endif; ?>
    </div>
</div>

<h2>Новости</h2>
<div class="card" style="margin-top:8px;">
    <h3>Создать новость</h3>
    <form method="post" action="index.php?route=admin/news/create" enctype="multipart/form-data" class="js-ajax-admin" data-target="admin-news-list">
        <label>Заголовок:
            <input type="text" name="title">
        </label>
        <label>Обложка (изображение, необязательно):
            <input type="file" name="image" accept="image/*">
        </label>
        <label>Текст:
            <textarea name="content"></textarea>
        </label>
        <button type="submit" class="btn">Сохранить</button>
    </form>
    <h3 style="margin-top:10px;">Список новостей</h3>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
        <span style="font-size:13px; color:#4b5563;">Существующие новости.</span>
        <button type="button" class="btn btn-secondary admin-toggle" data-target="admin-news-list">Свернуть / развернуть</button>
    </div>
    <div id="admin-news-list" class="admin-scroll">
        <?php if (!empty($news)): ?>
            <ul>
                <?php foreach ($news as $n): ?>
                    <li>
                        <?php echo htmlspecialchars($n['title']); ?>
                        <small>(<?php echo htmlspecialchars($n['created_at']); ?>)</small>
                        <form method="post" action="index.php?route=admin/news/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;" data-target="admin-news-list">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($n['id']); ?>">
                            <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Новостей пока нет.</p>
        <?php endif; ?>
    </div>
</div>

<h2>FAQ</h2>
<div class="card" style="margin-top:8px;">
    <h3>Добавить вопрос</h3>
    <form method="post" action="index.php?route=admin/faq/create" class="js-ajax-admin" data-target="admin-faq-list">
        <label>Вопрос:
            <input type="text" name="question">
        </label>
        <label>Ответ:
            <textarea name="answer"></textarea>
        </label>
        <button type="submit" class="btn">Сохранить</button>
    </form>
    <h3 style="margin-top:10px;">Список FAQ</h3>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
        <span style="font-size:13px; color:#4b5563;">Список вопросов.</span>
        <button type="button" class="btn btn-secondary admin-toggle" data-target="admin-faq-list">Свернуть / развернуть</button>
    </div>
    <div id="admin-faq-list" class="admin-scroll">
        <?php if (!empty($faq)): ?>
            <ul>
                <?php foreach ($faq as $f): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($f['question']); ?></strong>
                        <form method="post" action="index.php?route=admin/faq/delete" class="js-ajax-admin" style="display:inline-block; margin-left:8px;" data-target="admin-faq-list">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($f['id']); ?>">
                            <button type="submit" class="btn btn-secondary" style="padding:2px 6px; font-size:11px;">Удалить</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>FAQ пока пуст.</p>
        <?php endif; ?>
    </div>
</div>
