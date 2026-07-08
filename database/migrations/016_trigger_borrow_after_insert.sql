CREATE TRIGGER trg_borrow_after_insert
AFTER INSERT ON borrowings
FOR EACH ROW
BEGIN
    UPDATE books SET available_copies = available_copies - 1 WHERE book_id = NEW.book_id;
    INSERT INTO audit_logs (actor, action, table_name, record_id, details)
    VALUES (COALESCE(@app_user, CURRENT_USER()), 'INSERT', 'borrowings', NEW.borrowing_id,
            CONCAT('Book ', NEW.book_id, ' issued to member ', NEW.member_id));
END
