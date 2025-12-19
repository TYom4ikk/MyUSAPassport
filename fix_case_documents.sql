-- Удаляем старый внешний ключ к таблице cases
ALTER TABLE case_documents DROP FOREIGN KEY case_documents_ibfk_1;

-- Добавляем новый внешний ключ к migration_cases
ALTER TABLE case_documents ADD CONSTRAINT case_documents_ibfk_1 
FOREIGN KEY (case_id) REFERENCES migration_cases(id) ON DELETE CASCADE;
