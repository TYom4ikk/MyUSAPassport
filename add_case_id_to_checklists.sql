-- Добавляем колонку case_id в таблицу checklists
ALTER TABLE checklists ADD COLUMN case_id INT UNSIGNED NULL;

-- Добавляем внешний ключ с уникальным именем
ALTER TABLE checklists ADD CONSTRAINT fk_checklists_case_id 
FOREIGN KEY (case_id) REFERENCES cases(id) ON DELETE SET NULL;
