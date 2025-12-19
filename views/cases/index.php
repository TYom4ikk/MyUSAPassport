<?php
require_once __DIR__ . '/../../models/Case.php';
?>

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
    <h2>Ваши миграционные кейсы</h2>
    <p>Здесь вы можете создавать и управлять своими кейсами для каждого способа получения гражданства США.</p>
    
    <p style="margin-top: 15px;">
        <a href="index.php?route=case/create" class="btn btn-primary">+ Создать новый кейс</a>
    </p>
</div>

<?php if (!empty($cases)): ?>
    <div class="card-list">
        <?php foreach ($cases as $case): ?>
            <div class="card" style="border-left: 4px solid <?php 
                echo match($case['status']) {
                    'active' => '#28a745',
                    'completed' => '#007bff',
                    'paused' => '#ffc107',
                    'cancelled' => '#dc3545',
                    default => '#6c757d'
                }; 
            ?>;">
                <h3>
                    <?php echo htmlspecialchars($case['title']); ?>
                    <span style="float: right; font-size: 14px; color: #6c757d;">
                        <?php 
                        echo match($case['status']) {
                            'active' => 'Активен',
                            'completed' => 'Завершен',
                            'paused' => 'Приостановлен',
                            'cancelled' => 'Отменен',
                            default => $case['status']
                        }; 
                        ?>
                    </span>
                </h3>
                
                <p><strong>Способ:</strong> <?php echo (new MigrationCase())->getMethodTitle($case['method']); ?></p>
                
                <?php if (!empty($case['description'])): ?>
                    <p><?php echo nl2br(htmlspecialchars($case['description'])); ?></p>
                <?php endif; ?>
                
                <p style="font-size: 12px; color: #6c757d;">
                    Создан: <?php echo date('d.m.Y H:i', strtotime($case['created_at'])); ?>
                    <?php if ($case['updated_at'] !== $case['created_at']): ?>
                        | Обновлен: <?php echo date('d.m.Y H:i', strtotime($case['updated_at'])); ?>
                    <?php endif; ?>
                </p>
                
                <div style="margin-top: 15px;">
                    <a href="index.php?route=case/view&id=<?php echo $case['id']; ?>" class="btn btn-primary">Открыть кейс</a>
                    <a href="index.php?route=case/edit&id=<?php echo $case['id']; ?>" class="btn btn-secondary">Редактировать</a>
                    
                    <form method="post" action="index.php?route=case/delete" class="js-ajax-admin" style="display: inline-block; margin-left: 10px;">
                        <input type="hidden" name="id" value="<?php echo $case['id']; ?>">
                        <button type="submit" class="btn" style="background: #dc3545; color: white;" onclick="return confirm('Вы уверены, что хотите удалить этот кейс?')">Удалить</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="card">
        <p>У вас пока нет созданных кейсов.</p>
        <p style="margin-top: 15px;">
            <a href="index.php?route=case/create" class="btn btn-primary">Создать первый кейс</a>
        </p>
    </div>
<?php endif; ?>

<p style="margin-top: 20px;">
    <a href="index.php?route=profile" class="btn btn-secondary">← Вернуться в личный кабинет</a>
</p>
