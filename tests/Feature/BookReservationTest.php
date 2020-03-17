<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books', [
           'title' => 'book title',
           'author' => 'Author Name'
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());
    }

    /** @test */
    public function a_title_is_required() {

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Author Name'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_author_is_required() {

        $response = $this->post('/books', [
            'title' => 'title',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /**
     * @test
     */
    public function a_book_can_be_updated() {

        $this->withoutExceptionHandling();
        $this->post('/books', [
            'title' => 'title',
            'author' => 'author'
        ]);
        $book = Book::first();
        $response = $this->patch('/books/'.$book->id, [
            'title'=> 'new title',
            'author' => 'new author'
        ]);

        $this->assertEquals('new title', Book::first()->title);
        $this->assertEquals('new author', Book::first()->author);

    }
}
