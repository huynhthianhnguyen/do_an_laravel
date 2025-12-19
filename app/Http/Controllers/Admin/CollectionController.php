<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::paginate(10);
        return view('admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('admin.collections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_bo_suu_tap' => 'required|string|max:255',
        ]);

        Collection::create($request->all());
        return redirect()->route('admin.collections.index')->with('success', 'Thêm bộ sưu tập thành công');
    }

    public function edit(Collection $collection)
    {
        return view('admin.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collecyion $collection)
    {
        $collection->update($request->all());
        return redirect()->route('admin.collections.index')->with('success', 'Cập nhật bộ sưu tập thành công');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()->route('admin.collections.index')->with('success', 'Xóa bộ sưu tập thành công');
    }
}
