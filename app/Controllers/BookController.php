<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\BookService;
use App\Validators\BookValidator;
use App\Helpers\{Flash, Redirect, CSRF};

class BookController
{
    private BookService $svc;

    public function __construct() { $this->svc = new BookService(); }

    public function index(): void
    {
        $search = trim($_GET['q'] ?? '');
        $books  = $search !== '' ? $this->svc->search($search) : $this->svc->all();
        $pageTitle = 'Books';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/books/view_books_page.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function create(): void
    {
        $categories = $this->svc->categories();
        $pageTitle  = 'Add Book';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/books/add_book_form.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function store(): void
    {
        $v = new BookValidator();
        if (!$v->validate($_POST)) {
            Redirect::withError('/books/add_book.php', $v->firstError());
        }
        $this->svc->add([
            'isbn'           => trim($_POST['isbn']),
            'title'          => trim($_POST['title']),
            'author'         => trim($_POST['author']),
            'category_id'    => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'publisher'      => trim($_POST['publisher'] ?? ''),
            'published_year' => !empty($_POST['published_year']) ? (int)$_POST['published_year'] : null,
            'total_copies'   => (int)($_POST['total_copies'] ?? 1),
            'shelf_location' => trim($_POST['shelf_location'] ?? ''),
        ]);
        Redirect::withSuccess('/books/view_books.php', 'Book added successfully.');
    }

    public function edit(): void
    {
        $id   = (int)($_GET['id'] ?? 0);
        $book = $this->svc->find($id);
        if (!$book) { Redirect::withError('/books/view_books.php', 'Book not found.'); }
        $categories = $this->svc->categories();
        $pageTitle  = 'Edit Book';
        require BASE_PATH . '/includes/header.php';
        require BASE_PATH . '/includes/navbar.php';
        require BASE_PATH . '/includes/sidebar.php';
        require BASE_PATH . '/books/edit_book_form.php';
        require BASE_PATH . '/includes/footer.php';
    }

    public function update(): void
    {
        $id = (int)($_POST['book_id'] ?? 0);
        $v  = new BookValidator();
        if (!$v->validate($_POST)) {
            Redirect::withError("/books/edit_book.php?id={$id}", $v->firstError());
        }
        $this->svc->edit($id, [
            'isbn'           => trim($_POST['isbn']),
            'title'          => trim($_POST['title']),
            'author'         => trim($_POST['author']),
            'category_id'    => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'publisher'      => trim($_POST['publisher'] ?? ''),
            'published_year' => !empty($_POST['published_year']) ? (int)$_POST['published_year'] : null,
            'total_copies'   => (int)($_POST['total_copies'] ?? 1),
            'shelf_location' => trim($_POST['shelf_location'] ?? ''),
        ]);
        Redirect::withSuccess('/books/view_books.php', 'Book updated successfully.');
    }

    public function destroy(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $affected = $this->svc->delete($id);
        if ($affected === 0) {
            Redirect::withError('/books/view_books.php', 'Cannot delete — book has copies on loan or does not exist.');
        }
        Redirect::withSuccess('/books/view_books.php', 'Book deleted.');
    }
}
