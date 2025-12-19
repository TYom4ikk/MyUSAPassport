-- Обновление таблицы checklists для работы с migration_cases
-- Добавляем case_id если его нет
ALTER TABLE checklists ADD COLUMN IF NOT EXISTS case_id INT UNSIGNED NULL;

-- Добавляем внешний ключ к migration_cases
ALTER TABLE checklists ADD CONSTRAINT fk_checklist_case 
FOREIGN KEY (case_id) REFERENCES migration_cases(id) ON DELETE SET NULL;
