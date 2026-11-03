<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\BookCategory;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Book::with('bookCategory');

            return DataTables::eloquent($model)
                ->addIndexColumn()
                ->addColumn('coverImg', function ($data) {
                    return '<img src="' . e(asset($data->cover)) . '" alt="Sampul ' . e($data->title) . '" class="book-table-cover">';
                })
                ->editColumn('price', function ($data) {
                    return 'Rp ' . number_format($data->price, 0, ',', '.');
                })
                ->addColumn('category_name', function ($data) {
                    // mengambil nama kategori dari relasi book category id
                    return $data->bookCategory ? $data->bookCategory->name : '';
                })
                ->addColumn('action', function ($data) {
                    $bookDetails = e(json_encode([
                        'cover' => asset($data->cover),
                        'title' => $data->title,
                        'category' => $data->bookCategory->name ?? '-',
                        'price' => $data->price,
                        'writer' => $data->writer,
                        'publisher' => $data->publisher,
                        'language' => $data->language,
                        'pages' => $data->page_of_book,
                        'releaseDate' => $data->release_date
                            ? date('d M Y', strtotime($data->release_date))
                            : '-',
                        'description' => $data->description,
                    ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP));

                    $btnDetail = '<button type="button" class="btn btn-sm btn-outline-primary btn-detail" data-book="' . $bookDetails . '">
                        Detail
                    </button>';

                    $btnEdit = '<a href="' . route('admin.books.edit', $data->id) . '" class="btn btn-sm btn-primary">Edit</a>';

                    $btnDelete = '<form method="POST" action="' . route('admin.books.destroy', $data->id) . '" class="d-inline">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Yakin ingin menghapus buku ini?\')">Hapus</button>'
                        . '</form>';

                    return '<div class="book-table-actions">'
                        . $btnDetail . $btnEdit . $btnDelete .
                        '</div>';
                })
                ->rawColumns(['action', 'coverImg'])
                ->toJson();
        }

        return view('admin.books.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bookCategory = BookCategory::all();

        return view('admin.books.create', compact('bookCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            // mimes: menentukan file yg boleh diupload
            'cover' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'title' => ['required', 'string', 'min:3'],
            'writer' => ['required', 'string', 'min:3'],
            'publisher' => ['required', 'string', 'min:3'],
            'price' => ['required', 'numeric'],
            'release_date' => ['required', 'date'],
            'page_of_book' => ['required', 'numeric'],
            'language' => ['required'],
            // exists memastikan data id ada di table book_categories
            'book_category_id' => ['required', 'exists:book_categories,id'],
            'description' => ['nullable'] // boleh kosong
        ]);

        // proses penyimpanan file
        if ($request->file('cover')) {
            $cover = $request->file('cover');

            // rename nama gambar
            $name = time() . '-' . $cover->getClientOriginalName();

            // simpan gambar ke folder storage/app/public
            Storage::disk('public')->putFileAs('covers', $cover, $name);

            // simpan alamat penyimpanan gambar ke data validasi untuk dikirim ke db
            $validateData['cover'] = Storage::url('covers/' . $name);
        }

        Book::create($validateData);

        return redirect()->route('admin.books.index')
            ->with('success', 'Berhasil membuat data buku');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $bookCategories = BookCategory::all();

        return view('admin.books.edit', compact('book', 'bookCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validateData = $request->validate([
            // mimes: menentukan file yg boleh diupload
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'title' => ['required', 'string', 'min:3'],
            'writer' => ['required', 'string', 'min:3'],
            'publisher' => ['required', 'string', 'min:3'],
            'price' => ['required', 'numeric'],
            'release_date' => ['required', 'date'],
            'page_of_book' => ['required', 'numeric'],
            'language' => ['required'],
            // exists memastikan data id ada di table book_categories
            'book_category_id' => ['required', 'exists:book_categories,id'],
            'description' => ['nullable'] // boleh kosong
        ]);

        // proses penyimpanan file
        if ($request->file('cover')) {
            if ($book->cover) {
                $oldCoverPath = str_replace('/storage/', '', $book->cover);

                if (Storage::disk('public')->exists($oldCoverPath)) {
                    Storage::disk('public')->delete($oldCoverPath);
                }
            }

            $coverImage = $request->file('cover');
            $coverImageName = time() . '.' . $coverImage->getClientOriginalExtension();

            Storage::disk('public')->putFileAs('covers', $coverImage, $coverImageName);
            $validateData['cover'] = Storage::url('covers/' . $coverImageName);
        } else {
            unset($validateData['cover']);
        }

        $book->update($validateData);

        return redirect()->route('admin.books.index')
            ->with('success', 'Berhasil mengubah data buku');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover) {
            $oldCoverPath = str_replace('/storage/', '', $book->cover);
            if (Storage::disk('public')->exists($oldCoverPath)) {
                Storage::disk('public')->delete($oldCoverPath);
            }
        }

        $book->delete();
        return redirect()->route('admin.books.index')
            ->with('success', 'Berhasil membuat data buku');
    }
}
