<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::latest()->paginate(5);

        return view('books.index', compact('books'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('book.create', [
        //     'publishers' => Publisher::all()
        // ]);

        $publisher = Publisher::all();
        return view('book.create', compact('publishers', $publisher));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required'
        ]);

        Book::create($validatedData);

        return redirect()->route('book.index')->with('success', 'Berhasil Menyimpan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $publishers = Publisher::all();
        return view('books.edit', compact('book', 'publishers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
        ]);

        Book::where('id', $book->id)->update($validatedData);
        return redirect()->route('book.index')->with('success', 'Berhasil Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('book.index')->with('success', 'Berhasil Hapus!');
    }
}
