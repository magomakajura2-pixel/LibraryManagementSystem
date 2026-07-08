CREATE PROCEDURE sp_mark_overdue ()
BEGIN
    UPDATE borrowings SET status = 'overdue'
     WHERE status = 'borrowed' AND due_date < CURRENT_DATE;
END
