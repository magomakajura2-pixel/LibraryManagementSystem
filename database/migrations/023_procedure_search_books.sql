CREATE PROCEDURE sp_search_books (IN p_term VARCHAR(255))
BEGIN
    SELECT book_id, isbn, title, author, available_copies, status
      FROM books
     WHERE title LIKE CONCAT('%', p_term, '%')
        OR author LIKE CONCAT('%', p_term, '%')
        OR isbn  LIKE CONCAT('%', p_term, '%')
     ORDER BY title;
END
