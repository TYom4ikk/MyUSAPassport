<h1>Результат анкеты</h1>

<div class="card">
    <h2>Вероятность получения гражданства США</h2>
    <div style="text-align: center; margin: 20px 0;">
        <div style="font-size: 48px; font-weight: bold; color: <?php echo $result['probability'] >= 60 ? '#28a745' : '#dc3545'; ?>">
            <?php echo $result['probability']; ?>%
        </div>
        <div style="font-size: 18px; margin-top: 10px;">
            <?php echo $result['score']; ?> из 100 баллов
        </div>
    </div>
    
    <div style="margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <p style="font-size: 16px; margin: 0;">
            <strong>Да я хз, дадут ли гражданство такому лоху как ты</strong>
        </p>
    </div>
</div>

<p><a href="index.php?route=wizard" class="btn btn-secondary">Пройти анкету ещё раз</a></p>
<p><a href="index.php" class="btn">Вернуться на главную</a></p>
