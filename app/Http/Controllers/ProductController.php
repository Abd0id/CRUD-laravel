<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function step2()
    {
        $products = Product::latest()->take(5)->get();
        return view('crud-step-2-create', compact('products'));
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);
        Product::create($validated);
        return redirect()->back()->with('success', 'Produit créé !');

    }

    public function step3(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', $search)->get();
        return view('crud-step-3-read', compact('products'));
    }

    public function step4(Request $request)
    {
        $products = Product::latest()->take(5)->get();

        $selectedProduct = $request->has('id') ? Product::find($request->id) : null;
        return view('crud-step-4-update', compact('products', 'selectedProduct'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('products.edit')->with('success', 'Mis à jour !');

    }

    public function step5(Request $request)
    {
        $products = Product::latest()->take(5)->get();
        $totalCount = $products->count();

        return view('crud-step-5-delete', compact('products','totalCount'));
    }

        public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.delete_page')
            ->with('success', '💥 Produit supprimé avec succès !');
    }

        public function masterIndex(Request $request)
    {
        $products = Product::latest()->take(5)->get();
        $totalCount = $products->count();

        return view('crud-step-6-complete', compact('products','totalCount'));
    }

}
