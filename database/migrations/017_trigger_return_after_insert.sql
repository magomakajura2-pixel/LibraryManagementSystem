CREATE TRIGGER trg_return_after_insert
AFTER INSERT ON returns
FOR EACH ROW
BEGIN
    DECLARE v_book_id INT UNSIGNED; DECLARE v_member_id INT UNSIGNED;
    DECLARE v_due DATE; DECLARE v_days_late INT; DECLARE v_rate DECIMAL(10,2);
    SELECT book_id, member_id, due_date INTO v_book_id, v_member_id, v_due
      FROM borrowings WHERE borrowing_id = NEW.borrowing_id;
    UPDATE books SET available_copies = available_copies + 1 WHERE book_id = v_book_id;
    UPDATE borrowings SET status = CASE WHEN NEW.book_condition='lost' THEN 'lost' ELSE 'returned' END
      WHERE borrowing_id = NEW.borrowing_id;
    SET v_days_late = DATEDIFF(NEW.return_date, v_due);
    IF v_days_late > 0 THEN
        SELECT CAST(setting_value AS DECIMAL(10,2)) INTO v_rate FROM system_settings WHERE setting_key='fine_per_day';
        INSERT INTO fines (borrowing_id, member_id, amount, reason, issued_date)
        VALUES (NEW.borrowing_id, v_member_id, v_days_late * COALESCE(v_rate,0),
                CONCAT(v_days_late,' day(s) overdue'), NEW.return_date);
    END IF;
    INSERT INTO audit_logs (actor, action, table_name, record_id, details)
    VALUES (COALESCE(@app_user, CURRENT_USER()), 'INSERT', 'returns', NEW.return_id,
            CONCAT('Loan ', NEW.borrowing_id, ' returned'));
END
