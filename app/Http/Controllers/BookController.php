<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //GET /api/libros - Listar libros con paginación y filtros (título, autor, año)
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

    //POST /api/libros - Crear nuevo libro con validación de campos
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'published_at' => 'required|date',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
        ]);

        $book = Book::create($validated);
        $book->authors()->attach($validated['authors']);

        return response()->json($book->load('authors'), 201);
    }

    //PUT /api/libros/{id} - Actualizar libro existente con validación
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'published_at' => 'sometimes|required|date',
            'authors' => 'sometimes|required|array|min:1',
            'authors.*' => 'exists:authors,id',
        ]);

        $book->update($validated);
        if (isset($validated['authors'])) {
            $book->authors()->sync($validated['authors']);
        }

        return response()->json($book->load('authors'));
    }

    public function destroy(Book $book)
    {
        try {
            $book->update(['available_stock' => 0, 'deleted_at' => now()]);
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar el libro.'], 500);
        }
    }
}
