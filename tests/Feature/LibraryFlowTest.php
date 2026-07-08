<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_visit_dashboard(): void
    {
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $user = User::factory()->create([
            'username' => 'admin',
            'password_hash' => bcrypt('password'),
            'role_id' => 1,
        ]);

        $response = $this->post('/login', [
            'username' => 'admin',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_borrow_and_return_updates_stock_and_creates_fine_when_overdue(): void
    {
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $admin = User::factory()->create(['role_id' => 1, 'password_hash' => bcrypt('password')]);
        $member = Member::factory()->create(['status' => 'active']);
        $book = Book::factory()->create([
            'total_copies' => 2,
            'available_copies' => 2,
            'status' => 'available',
        ]);

        $this->actingAs($admin);

        // Borrow
        $this->post('/borrowings', [
            'book_id' => $book->book_id,
            'member_id' => $member->member_id,
            'librarian_id' => null,
            'loan_days' => 1,
        ])->assertRedirect('/borrowings');

        $book->refresh();
        $this->assertEquals(1, $book->available_copies);

        $borrowing = Borrowing::where('book_id', $book->book_id)->first();
        $this->assertNotNull($borrowing);

        // Force overdue
        $borrowing->update(['due_date' => now()->subDays(2)->toDateString()]);

        // Return
        $this->post('/returns', [
            'borrowing_id' => $borrowing->borrowing_id,
            'book_condition' => 'good',
            'received_by' => null,
        ])->assertRedirect('/returns');

        $book->refresh();
        $this->assertEquals(2, $book->available_copies);
        $this->assertDatabaseHas('fines', [
            'borrowing_id' => $borrowing->borrowing_id,
            'member_id' => $member->member_id,
            'status' => 'unpaid',
        ]);
    }
}
