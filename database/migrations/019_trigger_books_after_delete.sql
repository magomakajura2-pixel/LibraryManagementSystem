CREATE TRIGGER trg_books_after_delete
AFTER DELETE ON books
FOR EACH ROW
BEGIN
    INSERT INTO audit_logs (actor, action, table_name, record_id, details)
    VALUES (COALESCE(@app_user, CURRENT_USER()), 'DELETE', 'books', OLD.book_id, CONCAT('Deleted: ', OLD.title));
END
