<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPackage;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionPackageController extends Controller
{
     public function index(Request $request)
{
    if ($request->ajax()) {
        $model = SubscriptionPackage::query();

        return datatables()->eloquent($model)
            ->addIndexColumn()
            ->editColumn('price', function ($row) {
                return 'Rp ' . number_format($row->price, 0, ',', '.');
            })
            ->addColumn('color_display', function ($row) {
                return '
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="width:35px; height:35px; border-radius:5px; background:'.e($row->color).'; border:1px solid #ddd;"></div>
                        '.e($row->color).'
                    </div>
                ';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.subscription-packages.edit', $row->id);
                $destroyUrl = route('admin.subscription-packages.destroy', $row->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');

                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>
                    <form action="'.$destroyUrl.'" method="POST" class="d-inline">
                        '.$csrf.'
                        '.$method.'
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>
                    </form>
                ';
            })
            ->rawColumns(['color_display', 'action'])
            ->toJson();
    }

    return view('admin.subscription-packages.index');
}
    public function create()
    {
        return view('admin.subscription-packages.create');
    }

    public function store(Request $request) //store memproses data yang mau di tambah
    {
        $request->validate([
            'name_package' => 'required',
            'price' => 'required|numeric',
            'color' => ['required', 'regex:/\A#[0-9a-fA-F]{6}\z/'],
            'description' => 'nullable',
        ]);

        SubscriptionPackage::create([
            'name_package' => $request->name_package,
            'price' => $request->price,
            'color' => $request->color,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil ditambahkan.');
    }

    public function edit($id) //menampilkan tampilan edit berdasarkan id
    {
        $package = SubscriptionPackage::findOrFail($id);

        return view('admin.subscription-packages.edit', compact('package'));
    }

    public function update(Request $request, $id) //memproses data
    {
        $request->validate([
            'name_package' => 'required',
            'price' => 'required|numeric',
            'color' => ['required', 'regex:/\A#[0-9a-fA-F]{6}\z/'],
            'description' => 'nullable',
        ]);

        $package = SubscriptionPackage::findOrFail($id);

        $package->update([
            'name_package' => $request->name_package,
            'price' => $request->price,
            'color' => $request->color,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil diubah.');
    }

    public function destroy($id) //memproses data yang ingin di hapus
    {
        $package = SubscriptionPackage::findOrFail($id);

        $package->delete();

        return redirect()->route('admin.subscription-packages.index')->with('success', 'Paket langganan berhasil dihapus.');
    }
}
