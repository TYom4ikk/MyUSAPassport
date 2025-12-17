<h1>Админ-панель</h1>
<p>Вы вошли как администратор.</p>

<h2>Кейсы пользователей</h2>
<p>Здесь можно менять статус кейса. Пользователь увидит его на странице "Мой кейс и документы".</p>

<?php if (!empty($cases)): ?>
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
            <span style="font-size:13px; color:#4b5563;">Список кейсов.</span>
            <button type="button" class="btn btn-secondary admin-toggle" data-target="admin-cases-table">Свернуть / развернуть</button>
        </div>
        <div id="admin-cases-table" class="admin-scroll">
        <table style="width:100%; font-size: 13px; border-collapse: collapse;">
            <tr>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">ID</th>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">Пользователь</th>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">Email</th>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">Статус</th>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">Изменить</th>
            </tr>
            <?php foreach ($cases as $c): ?>
                <tr>
                    <td style="padding:4px;">#<?php echo htmlspecialchars($c['id']); ?></td>
                    <td style="padding:4px; "><?php echo htmlspecialchars($c['user_name']); ?></td>
                    <td style="padding:4px; "><?php echo htmlspecialchars($c['user_email']); ?></td>
                    <td style="padding:4px; "><?php echo htmlspecialchars($c['status']); ?></td>
                    <td style="padding:4px; ">
                        <form method="post" action="index.php?route=admin/case/status" class="js-ajax-admin">
                            <input type="hidden" name="case_id" value="<?php echo htmlspecialchars($c['id']); ?>">
                            <select name="status" style="font-size: 12px;">
                                <option value="Not started" <?php echo $c['status']==='Not started' ? 'selected' : ''; ?>>Not started</option>
                                <option value="Collecting documents" <?php echo $c['status']==='Collecting documents' ? 'selected' : ''; ?>>Collecting documents</option>
                                <option value="Ready to file" <?php echo $c['status']==='Ready to file' ? 'selected' : ''; ?>>Ready to file</option>
                                <option value="Filed" <?php echo $c['status']==='Filed' ? 'selected' : ''; ?>>Filed</option>
                                <option value="Biometrics scheduled" <?php echo $c['status']==='Biometrics scheduled' ? 'selected' : ''; ?>>Biometrics scheduled</option>
                                <option value="Interview" <?php echo $c['status']==='Interview' ? 'selected' : ''; ?>>Interview</option>
                                <option value="Oath" <?php echo $c['status']==='Oath' ? 'selected' : ''; ?>>Oath</option>
                                <option value="Done" <?php echo $c['status']==='Done' ? 'selected' : ''; ?>>Done</option>
                            </select>
                            <button type="submit" class="btn" style="padding:4px 10px; margin-left:4px;">Сохранить</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    var toggles = document.querySelectorAll('.admin-toggle');
    toggles.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var targetId = btn.getAttribute('data-target');
            var el = document.getElementById(targetId);
            if (!el) return;
            if (el.style.display === 'none') {
                el.style.display = '';
            } else {
                el.style.display = 'none';
            }
        });
    });
});
</script>
</div>
<?php else: ?>
    <p>Кейсов пока нет.</p>
<?php endif; ?>

<h2>Пользователи</h2>
<div class="card" style="margin-top:8px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
        <p style="margin:0; font-size:13px; color:#4b5563;">Список зарегистрированных пользователей.</p>
        <button type="button" class="btn btn-secondary admin-toggle" data-target="admin-users-table">Свернуть / развернуть</button>
    </div>
    <?php if (!empty($users)): ?>
        <div id="admin-users-table" class="admin-scroll">
        <table style="width:100%; font-size: 13px; border-collapse: collapse;">
            <tr>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">ID</th>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">Имя</th>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">Email</th>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">Роль</th>
                <th style="text-align:left; border-bottom:1px solid rgba(255,255,255,0.2); padding:4px;">Смена роли</th>
            </tr>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td style="padding:4px;">#<?php echo htmlspecialchars($u['id']); ?></td>
                    <td style="padding:4px; "><?php echo htmlspecialchars($u['name']); ?></td>
                    <td style="padding:4px; "><?php echo htmlspecialchars($u['email']); ?></td>
                    <td style="padding:4px; "><?php echo htmlspecialchars($u['role']); ?></td>
                    <td style="padding:4px; ">
                        <form method="post" action="index.php?route=admin/user/role" class="js-ajax-admin">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($u['id']); ?>">
                            <select name="role" style="font-size:12px;">
                                <option value="user" <?php echo $u['role']==='user' ? 'selected' : ''; ?>>user</option>
                                <option value="admin" <?php echo $u['role']==='admin' ? 'selected' : ''; ?>>admin</option>
                            </select>
                            <button type="submit" class="btn" style="padding:4px 10px; margin-left:4px;">OK</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        </div>
    <?php else: ?>
        <p>Пользователей пока нет.</p>
    <?php endif; ?>
</div>

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
