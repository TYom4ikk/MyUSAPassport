<h1>Модерация документов</h1>

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

<div class="card">
    <h2>Документы на проверке</h2>
    
    <?php if (!empty($pendingDocuments)): ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">ID</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Пользователь</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Email</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Название документа</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Этап</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Файл</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Загружен</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendingDocuments as $doc): ?>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px;"><?php echo $doc['id']; ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($doc['user_name']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($doc['email']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($doc['title']); ?></td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($doc['stage']); ?></td>
                        <td style="padding: 12px;">
                            <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank" class="btn btn-small">Открыть</a>
                        </td>
                        <td style="padding: 12px;"><?php echo date('d.m.Y H:i', strtotime($doc['uploaded_at'])); ?></td>
                        <td style="padding: 12px; min-width: 300px;">
                            <form method="post" action="index.php?route=admin/updateDocumentStatus" class="js-ajax-admin" style="display: block; white-space: nowrap;">
                                <input type="hidden" name="document_id" value="<?php echo $doc['id']; ?>">
                                
                                <div style="margin-bottom: 5px;">
                                    <select name="status" style="padding: 4px; width: 120px;">
                                        <option value="approved">Одобрить</option>
                                        <option value="rejected">Отклонить</option>
                                    </select>
                                </div>
                                
                                <div style="margin-bottom: 5px;">
                                    <input type="text" name="admin_comment" placeholder="Комментарий (при отклонении)" style="padding: 4px; width: 100%;">
                                </div>
                                
                                <button type="submit" class="btn btn-small" style="padding: 4px 8px;">Сохранить</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="padding: 20px; text-align: center; color: #6c757d;">
            Документов на проверке нет
        </p>
    <?php endif; ?>
</div>

<div style="margin-top: 20px;">
    <a href="index.php?route=admin" class="btn btn-secondary">← Админ-панель</a>
</div>
