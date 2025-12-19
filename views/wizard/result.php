<h1>Ваши персональные рекомендации</h1>

<div class="card">
    <h2>Подходящие способы получения гражданства США</h2>
    <p>На основе ваших ответов мы подобрали оптимальные варианты:</p>
</div>

<?php if (!empty($result['recommendations'])): ?>
    <?php foreach ($result['recommendations'] as $index => $recommendation): ?>
        <div class="card" style="border-left: 4px solid <?php echo $recommendation['priority'] === 'high' ? '#28a745' : ($recommendation['priority'] === 'medium' ? '#ffc107' : '#6c757d'); ?>;">
            <h3>
                <?php echo $index + 1; ?>. <?php echo htmlspecialchars($recommendation['title']); ?>
                <?php if ($recommendation['priority'] === 'high'): ?>
                    <span style="background: #28a745; color: white; padding: 2px 8px; border-radius: 3px; font-size: 12px;">Наилучший вариант</span>
                <?php elseif ($recommendation['priority'] === 'medium'): ?>
                    <span style="background: #ffc107; color: black; padding: 2px 8px; border-radius: 3px; font-size: 12px;">Хороший вариант</span>
                <?php endif; ?>
            </h3>
            <p><?php echo htmlspecialchars($recommendation['description']); ?></p>
            <p style="margin-top: 15px;">
                <a href="index.php?route=methods/<?php echo $recommendation['method']; ?>" class="btn btn-primary">Подробнее об этом способе</a>
            </p>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="card">
        <p>К сожалению, на основе ваших ответов мы не смогли определить подходящие способы. Рекомендуем ознакомиться со всеми доступными вариантами.</p>
        <p style="margin-top: 15px;">
            <a href="index.php?route=methods" class="btn btn-primary">Все способы получения гражданства</a>
        </p>
    </div>
<?php endif; ?>

<div class="card">
    <h3>Что делать дальше?</h3>
    <ol>
        <li>Изучите подробно рекомендуемые способы</li>
        <li>Оцените свои возможности и ресурсы</li>
        <li>Проконсультируйтесь с иммиграционным юристом</li>
        <li>Начните подготовку документов</li>
    </ol>
</div>

<div class="card" style="background: #f8f9fa; border: 1px solid #dee2e6;">
    <h3>Важное замечание</h3>
    <p>Эта анкета носит информационный характер и не является юридической консультацией. Для получения точной информации о вашем случае обратитесь к квалифицированному иммиграционному юристу.</p>
</div>

<p style="margin-top: 20px;">
    <a href="index.php?route=methods" class="btn btn-secondary">← Все способы получения гражданства</a>
    <a href="index.php?route=wizard" class="btn btn-secondary">Пройти анкету заново</a>
</p>
<a href="index.php" class="btn">Вернуться на главную</a>
