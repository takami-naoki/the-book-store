<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\Book as BookResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BooksController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', Book::class);
        return BookResource::collection(request()->user()->books);
    }

    public function store()
    {
        $this->authorize('create', Book::class);
        $book = request()->user()->books()->create($this->validataData());
        return (new BookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Book $book)
    {
        $this->authorize('view', $book);
        return new BookResource($book);
    }

    public function update(Book $book)
    {
        $this->authorize('update', $book);
        $book->update($this->validataData());

        return (new BookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);
        $book->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    private function validataData()
    {
        return request()->validate([
            'title' => 'required',
            'description' => 'required',
            'published_at' => 'required',
        ]);
    }

}
