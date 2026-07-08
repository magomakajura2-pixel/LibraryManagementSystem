CREATE TRIGGER trg_books_stock_guard
BEFORE UPDATE ON books
FOR EACH ROW
BEGIN
    IF NEW.available_copies < 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock error: available_copies cannot be negative.';
    END IF;
    IF NEW.available_copies > NEW.total_copies THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock error: available_copies cannot exceed total_copies.';
    END IF;
END
