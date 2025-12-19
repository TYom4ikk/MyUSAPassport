<h1>Создать новый кейс</h1>

<div id="case-create-message"></div>

<form method="post" action="index.php?route=case/create" class="js-ajax" data-target="case-create-message">
    <div class="card">
        <h2>Основная информация</h2>
        
        <label>Название кейса *
            <input type="text" name="title" required placeholder="Например: Натурализация через грин-карту" style="width: 100%; max-width: 400px;">
        </label>
        
        <label>Способ получения гражданства *
            <select name="method" required style="width: 100%; max-width: 400px;">
                <option value="">Выберите способ</option>
                <option value="naturalization">Натурализация</option>
                <option value="greencard">Лотерея Green Card</option>
                <option value="marriage">Брак с гражданином США</option>
                <option value="investment">Инвестиции (EB-5)</option>
                <option value="military">Служба в армии США</option>
                <option value="employment">Рабочая миграция</option>
            </select>
        </label>
        
        <label>Описание
            <textarea name="description" placeholder="Опишите ваш случай, цели и текущий статус..." style="width: 100%; height: 120px;"></textarea>
        </label>
    </div>
    
    <div class="card">
        <h2>Что дальше?</h2>
        <p>После создания кейса вы сможете:</p>
        <ul>
            <li>Создавать чек-листы для этого способа</li>
            <li>Загружать необходимые документы</li>
            <li>Отслеживать прогресс</li>
            <li>Получать рекомендации</li>
        </ul>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Создать кейс</button>
        <a href="index.php?route=case" class="btn btn-secondary">Отмена</a>
    </div>
</form>
