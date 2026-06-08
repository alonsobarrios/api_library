<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('author');

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('author')) {
            $query->whereHas('author', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('author') . '%');
            });
        }

        if ($request->has('year')) {
            $query->whereYear('published_at', $request->input('year'));
        }

        return response()->json($query->paginate(10));
    }

    public function show(Book $book)
    {
        return response()->json($book->load('authors'));
    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());
        $book->authors()->attach($request->validated()['authors']);

        return response()->json($book->load('authors'), 201);
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        if (isset($request->validated()['authors'])) {
            $book->authors()->sync($request->validated()['authors']);
        }

        return response()->json($book->load('authors'));
    }

    public function destroy(Book $book)
    {
        try {
            $book->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar el libro.'], 500);
        }
    }
}
