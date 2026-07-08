-- Migration 013 — secondary indexes
CREATE INDEX idx_books_title   ON books (title);
CREATE INDEX idx_books_author  ON books (author);
CREATE INDEX idx_books_category ON books (category_id);
CREATE INDEX idx_members_name  ON members (last_name, first_name);
CREATE INDEX idx_borrow_status ON borrowings (status);
CREATE INDEX idx_borrow_due    ON borrowings (due_date);
CREATE INDEX idx_borrow_book   ON borrowings (book_id);
CREATE INDEX idx_borrow_member ON borrowings (member_id);
CREATE INDEX idx_returns_date  ON returns (return_date);
CREATE INDEX idx_fines_status  ON fines (status);
CREATE INDEX idx_audit_table   ON audit_logs (table_name, created_at);
