-- Добавляем колонку статуса в таблицу case_documents
ALTER TABLE case_documents ADD COLUMN status ENUM('pending', 'under_review', 'approved', 'rejected') NOT NULL DEFAULT 'pending';

-- Добавляем колонку для комментариев администратора
ALTER TABLE case_documents ADD COLUMN admin_comment TEXT NULL;
