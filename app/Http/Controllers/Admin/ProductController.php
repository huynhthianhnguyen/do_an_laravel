<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
          $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'gia_khuyen_mai' => 'nullable|numeric|min:0',
            'mau_sac' => 'nullable|string|max:100',
            'kich_thuoc' => 'nullable|string|max:50',
            'ma_sp' => 'nullable|string|max:50',
            'mo_ta' => 'nullable|string',
            'so_luong' => 'nullable|integer|min:0',
            'anh.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('anh');

        if ($request->hasFile('anh')) {
            $paths = [];
            foreach ($request->file('anh') as $file) {
                $paths[] = $file->store('products', 'public');
            }
            $data['anh'] = json_encode($paths);
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'gia_khuyen_mai' => 'nullable|numeric|min:0',
            'mau_sac' => 'nullable|string|max:100',
            'kich_thuoc' => 'nullable|string|max:50',
            'ma_sp' => 'nullable|string|max:50',
            'mo_ta' => 'nullable|string',
            'so_luong' => 'nullable|integer|min:0',
            'anh.*' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('anh');

        if ($request->hasFile('anh')) {
            $paths = [];
            foreach ($request->file('anh') as $file) {
                $paths[] = $file->store('products', 'public');
            }
            $data['anh'] = json_encode($paths);
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
    }
}
