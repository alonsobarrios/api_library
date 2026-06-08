<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        return response()->json($query->paginate(10));
    }

    public function show(Author $author)
    {
        return response()->json($author);
    }

    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->validated());
        return response()->json($author, 201);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());
        return response()->json($author);
    }

    public function destroy(Author $author, AuthorService $service)
    {
        try {
            $service->delete($author);
            return response()->json(null, 204);
        } catch (\DomainException $ex) {
            return response()->json(['error' => $ex->getMessage()], 409);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar el autor.'], 500);
        }
    }
}
