CREATE PROCEDURE sp_borrow_book (
    IN p_book_id INT UNSIGNED, IN p_member_id INT UNSIGNED,
    IN p_librarian_id INT UNSIGNED, IN p_loan_days INT)
BEGIN
    DECLARE v_available INT; DECLARE v_status VARCHAR(20);
    DECLARE EXIT HANDLER FOR SQLEXCEPTION BEGIN ROLLBACK; RESIGNAL; END;
    START TRANSACTION;
        SELECT available_copies INTO v_available FROM books WHERE book_id = p_book_id FOR UPDATE;
        SELECT status INTO v_status FROM members WHERE member_id = p_member_id;
        IF v_available IS NULL THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Book does not exist.';
        END IF;
        IF v_available < 1 THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'No copies available to borrow.';
        END IF;
        IF v_status <> 'active' THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Member is not active.';
        END IF;
        INSERT INTO borrowings (book_id, member_id, librarian_id, borrow_date, due_date)
        VALUES (p_book_id, p_member_id, p_librarian_id, CURRENT_DATE,
                DATE_ADD(CURRENT_DATE, INTERVAL COALESCE(p_loan_days,14) DAY));
    COMMIT;
END
