-- Migration 014 — views
CREATE OR REPLACE VIEW vw_book_availability AS
SELECT b.book_id, b.isbn, b.title, b.author, c.name AS category,
       b.total_copies, b.available_copies,
       (b.total_copies - b.available_copies) AS copies_on_loan, b.status
FROM   books b LEFT JOIN categories c ON c.category_id = b.category_id;
CREATE OR REPLACE VIEW vw_overdue_books AS
SELECT br.borrowing_id, b.book_id, b.title, m.member_id,
       CONCAT(m.first_name,' ',m.last_name) AS member_name,
       br.borrow_date, br.due_date, DATEDIFF(CURRENT_DATE, br.due_date) AS days_overdue
FROM   borrowings br
JOIN   books   b ON b.book_id   = br.book_id
JOIN   members m ON m.member_id = br.member_id
WHERE  br.status IN ('borrowed','overdue') AND br.due_date < CURRENT_DATE;
CREATE OR REPLACE VIEW vw_most_borrowed_books AS
SELECT b.book_id, b.title, b.author, COUNT(br.borrowing_id) AS times_borrowed
FROM   books b LEFT JOIN borrowings br ON br.book_id = b.book_id
GROUP BY b.book_id, b.title, b.author
ORDER BY times_borrowed DESC;
CREATE OR REPLACE VIEW vw_member_summary AS
SELECT m.member_id, CONCAT(m.first_name,' ',m.last_name) AS member_name, m.status,
       COUNT(DISTINCT br.borrowing_id) AS total_borrowings,
       SUM(CASE WHEN br.status IN ('borrowed','overdue') THEN 1 ELSE 0 END) AS active_loans,
       COALESCE(SUM(CASE WHEN f.status='unpaid' THEN f.amount ELSE 0 END),0) AS outstanding_fines
FROM   members m
LEFT JOIN borrowings br ON br.member_id = m.member_id
LEFT JOIN fines      f  ON f.member_id  = m.member_id
GROUP BY m.member_id, member_name, m.status;
