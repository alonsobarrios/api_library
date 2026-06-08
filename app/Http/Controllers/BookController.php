<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('authors');

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        if ($request->has('author')) {
            $query->whereHas('authors', function ($q) use ($request) {
                $term = $request->input('author');
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $term . '%']);
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
        try {
            DB::beginTransaction();

            $book = Book::create($request->validated());

            $pivotData = [];
            $selectedAuthors = $request->validated()['authors'] ?? [];
            foreach ($selectedAuthors as $index => $authorId) {
                $pivotData[$authorId] = [
                    'author_order' => $index + 1
                ];
            }

            $book->authors()->attach($pivotData);

            DB::commit();
            return response()->json($book->load('authors'), 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => 'Error al intentar crear el libro'], 500);
        }
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            DB::beginTransaction();
            $book->update($request->validated());
            if (isset($request->validated()['authors'])) {
                $pivotData = [];
                $selectedAuthors = $request->validated()['authors'] ?? [];
                foreach ($selectedAuthors as $index => $authorId) {
                    $pivotData[$authorId] = [
                        'author_order' => $index + 1
                    ];
                }

                $book->authors()->sync($pivotData);
            }

            DB::commit();

            return response()->json($book->load('authors'));
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['error' => 'Error al intentar actualizar el libro'], 500);
        }
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
