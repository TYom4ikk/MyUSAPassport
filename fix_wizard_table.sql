-- Увеличиваем размер поля result для хранения JSON данных
ALTER TABLE wizard_responses MODIFY COLUMN result TEXT;
