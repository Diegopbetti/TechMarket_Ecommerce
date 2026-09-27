<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductManagementController extends Controller
{
    public function index(){
        $products = Product::with('announcer')->paginate(5);
        return view('product_management', compact('products'));
    }

    public function store(Request $request){
        $request->validate([
            'photo' => 'required|image', 
            'name' => 'required|string|max:255', 
            'category' => 'required|string|max:255', 
            'price' => 'required|numeric|min:0', 
            'description' => 'required|string', 
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->quantity = 1;
        $product->description = $request->description;
        $product->announcer_id = auth()->id();

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('product_images', 'public');
            $product->photo = $photoPath;
        }

        $product->save();

        return redirect()->route('product_management')->with('success', 'Produto criado com sucesso!');
    }

    public function update(Request $request, $id){
        $request->validate([
            'photo' => 'nullable|image', 
            'name' => 'required|string|max:255', 
            'category' => 'required|string|max:255', 
            'price' => 'required|numeric|min:0', 
            'description' => 'required|string', 
        ]);

        $product = Product::findOrFail($id);

        if($product->announcer_id !== auth()->id()){
            abort(403, 'Você não tem permissão para editar este produto.');
        }

        $product->name = $request->name;
        $product->category = $request->category;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('product_images', 'public');
            $product->photo = $photoPath;
        }

        $product->save();

        return redirect()->route('product_management')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id){
        $product = Product::findOrFail($id);

        if($product->announcer_id !== auth()->id()){
            abort(403, 'Você não tem permissão para excçuir este produto.');
        }

        $product->delete();

        return redirect()->route('product_management');
    }
}