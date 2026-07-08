CREATE TRIGGER trg_books_after_insert
AFTER INSERT ON books
FOR EACH ROW
BEGIN
    INSERT INTO audit_logs (actor, action, table_name, record_id, details)
    VALUES (COALESCE(@app_user, CURRENT_USER()), 'INSERT', 'books', NEW.book_id, CONCAT('Added: ', NEW.title));
END
