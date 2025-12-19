<h1>Управление пользователями</h1>

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
    <h2>Все пользователи</h2>
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">ID</th>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Имя</th>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Email</th>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Роль</th>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Зарегистрирован</th>
                <th style="padding: 12px; text-align: left; border-bottom: 1px solid #dee2e6;">Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 12px;"><?php echo $user['id']; ?></td>
                        <td style="padding: 12px;">
                            <?php echo htmlspecialchars($user['name']); ?>
                            <?php if ($user['id'] === Auth::userId()): ?>
                                <span style="background: #007bff; color: white; padding: 2px 6px; border-radius: 3px; font-size: 11px;">Вы</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 12px;"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td style="padding: 12px;">
                            <span style="padding: 2px 6px; border-radius: 3px; font-size: 11px; background: <?php 
                                echo $user['role'] === 'admin' ? '#dc3545' : '#28a745'; 
                            ?>; color: white;">
                                <?php echo $user['role'] === 'admin' ? 'Админ' : 'Пользователь'; ?>
                            </span>
                        </td>
                        <td style="padding: 12px;"><?php echo date('d.m.Y H:i', strtotime($user['created_at'])); ?></td>
                        <td style="padding: 12px;">
                            <?php if ($user['id'] !== Auth::userId()): ?>
                                <form method="post" action="index.php?route=admin/deleteUser" class="js-ajax-admin" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-small" style="background: #dc3545; color: white;" onclick="return confirm('Удалить пользователя <?php echo htmlspecialchars($user['name']); ?>?')">Удалить</button>
                                </form>
                            <?php else: ?>
                                <span style="color: #6c757d; font-size: 12px;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 20px; text-align: center; color: #6c757d;">
                        Пользователей пока нет
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="margin-top: 20px;">
    <a href="index.php?route=admin" class="btn btn-secondary">← Админ-панель</a>
</div>
