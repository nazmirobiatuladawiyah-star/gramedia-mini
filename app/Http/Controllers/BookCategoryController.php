<?php

namespace App\Http\Controllers;

use App\Models\BookCategory;
use App\Models\Book;
use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BookCategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori buku untuk sisi Admin (Mendukung DataTables AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categories = BookCategory::query();

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.book-categories.edit', $row->id);
                    $deleteUrl = route('admin.book-categories.destroy', $row->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');

                    return '
                        <a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin ingin menghapus?\')">
                            ' . $csrf . '
                            ' . $method . '
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.book-categories.index');
    }

    /**
     * Menampilkan form tambah kategori (Admin)
     */
    public function create()
    {
        return view('admin.book-categories.create');
    }

    /**
     * Menyimpan data kategori baru (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        BookCategory::create($request->all());

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil ditambahkan');
    }

    /**
     * Menampilkan buku sesuai kategori yang diklik beserta fitur Search dan Sort
     */
    public function showBooks(Request $request, $id)
    {
        $category = BookCategory::findOrFail($id);

        // Ambil buku 
        $query = Book::where('book_category_id', $category->id);

        // search
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                  ->orWhere('writer', 'LIKE', "%{$keyword}%");
            });
        }

        //dropdown
        if ($request->filled('sort')) {
            if ($request->sort === 'termurah') {
                $query->orderBy('price', 'asc');
            } elseif ($request->sort === 'termahal') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort === 'terbaru') {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $books = $query->paginate(12)->withQueryString();
        $subscriptionPackages = SubscriptionPackage::query()
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(3)
            ->get();

        return view('admin.books.category', compact('category', 'books', 'subscriptionPackages'));
    }

    /**
     * Menampilkan form edit kategori (Admin)
     */
    public function edit(string $id)
    {
        $category = BookCategory::findOrFail($id);
        return view('admin.book-categories.edit', compact('category'));
    }

    /**
     * Update data kategori (Admin)
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = BookCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil diperbarui');
    }

    /**
     * Hapus kategori (Admin)
     */
    public function destroy(string $id)
    {
        $category = BookCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.book-categories.index')->with('success', 'Kategori buku berhasil dihapus');
    }
}

