<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BooksTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();

    }

    /** @test */
    public function an_unauthenticated_user_should_redirected_to_login()
    {
        $response = $this->post('/api/books', array_merge($this->data(), ['api_token' => '']));
        $response->assertRedirect('/login');
        $this->assertCount(0, Book::all());
    }

    /** @test */
    public function a_list_of_books_can_be_fetched_for_the_authenticated_user()
    {
        $user = factory(User::class)->create();
        $anotherUser = factory(User::class)->create();

        $book = factory(Book::class)->create(['user_id' => $user->id]);
        $anotherBook = factory(Book::class)->create(['user_id' => $anotherUser->id]);
        $response = $this->get('/api/books?api_token=' . $user->api_token);
        $response->assertJsonCount(1)
            ->assertJson([
                    'data' => [
                        [
                            'data' => [
                                'book_id' => $book->id
                            ]
                        ]
                    ]
                ]
            );
    }

    /** @test */
    public function an_authenticated_user_can_add_a_book()
    {
        $response = $this->post('/api/books', $this->data());

        $book = Book::first();
        $this->assertEquals('Test Title', $book->title);
        $this->assertEquals('Test Description', $book->description);
        $this->assertEquals('05/14/1988', $book->published_at->format('m/d/Y'));
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            'data' => [
                'book_id' => $book->id
            ],
            'links' => [
                'self' => $book->path(),
            ]
        ]);
    }

    /** @test */
    public function fields_are_required()
    {
        collect(['title', 'description', 'published_at'])
            ->each(function ($field) {
                $response = $this->post('/api/books', array_merge($this->data(), [$field => '']));
                $response->assertSessionHasErrors($field);
                $this->assertCount(0, Book::all());
            });
    }

    /** @test */
    public function published_at_are_properly_stored()
    {
        $this->post('/api/books', array_merge($this->data()));
        $this->assertCount(1, Book::all());
        $this->assertInstanceOf(Carbon::class, Book::first()->published_at);
        $this->assertEquals('05/14/1988', Book::first()->published_at->format('m/d/Y'));
    }

    /** @test */
    public function a_book_can_be_retrieved()
    {
        $this->withoutExceptionHandling();
        $book = factory(Book::class)->create(['user_id' => $this->user->id]);
        $response = $this->get('/api/books/' . $book->id . '?api_token=' . $this->user->api_token);
        $response->assertJson([
            'data' => [
                'book_id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'published_at' => $book->published_at->format('m/d/Y'),
                'last_updated' => $book->updated_at->diffForHumans()
            ]
        ]);
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $book = factory(Book::class)->create(['user_id' => $this->user->id]);
        $response = $this->delete('/api/books/' . $book->id, ['api_token' => $this->user->api_token]);
        $this->assertCount(0, Book::all());
        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    /** @test */
    public function only_the_owner_can_delete_the_book()
    {
        $book = factory(Book::class)->create(['user_id' => $this->user->id]);
        $anotherUser = factory(User::class)->create();
        $response = $this->delete('/api/books/' . $book->id, ['api_token' => $anotherUser->api_token]);
        $response->assertStatus(403);
    }

    /** @test */
    public function a_book_can_be_patched()
    {
        $book = factory(Book::class)->create(['user_id' => $this->user->id]);
        $response = $this->patch('/api/books/' . $book->id, $this->data());
        $book = $book->fresh();

        $this->assertEquals('Test Title', $book->title);
        $this->assertEquals('Test Description', $book->description);
        $this->assertEquals('05/14/1988', $book->published_at->format('m/d/Y'));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'book_id' => $book->id
            ],
            'links' => [
                'self' => $book->path(),
            ]
        ]);
    }

    /** @test */
    public function only_the_owner_of_the_book_can_patch_the_book()
    {
        $book = factory(Book::class)->create();
        $anotherUser = factory(User::class)->create();
        $response = $this->patch('/api/books/' . $book->id, array_merge($this->data(), ['api_token' => $anotherUser->api_token]));

        $response->assertStatus(403);
    }

    private function data()
    {
        return [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'published_at' => '05/14/1988',
            'api_token' => $this->user->api_token
        ];
    }
}
