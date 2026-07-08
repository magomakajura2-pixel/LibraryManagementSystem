CREATE PROCEDURE sp_return_book (
    IN p_borrowing_id INT UNSIGNED,
    IN p_condition ENUM('good','damaged','lost'),
    IN p_received_by INT UNSIGNED)
BEGIN
    DECLARE v_exists INT;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN ROLLBACK; RESIGNAL; END;
    START TRANSACTION;
        SELECT COUNT(*) INTO v_exists FROM borrowings
         WHERE borrowing_id = p_borrowing_id AND status IN ('borrowed','overdue');
        IF v_exists = 0 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No open loan found for that borrowing id.';
        END IF;
        INSERT INTO returns (borrowing_id, return_date, book_condition, received_by)
        VALUES (p_borrowing_id, CURRENT_DATE, COALESCE(p_condition,'good'), p_received_by);
    COMMIT;
END
