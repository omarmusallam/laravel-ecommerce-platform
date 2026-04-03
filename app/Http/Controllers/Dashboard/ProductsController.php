<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class ProductsController extends Controller
{

    public function query(Request $request)
    {
        return Product::with(['category', 'store'])
            ->orderby('products.created_at', 'desc')
            ->when($request->name, function ($query, $value) {
                $query->where('name', 'LIKE', "%{$value}%");
            })
            ->when($request->category_id, function ($query, $value) {
                $query->where('category_id', '=', $value);
            });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Product::class);
        $request = request();
        $products = $this->query($request)->paginate();
        $categories = Category::all();
        return view('dashboard.products.index', compact('products', 'categories'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Product::class);
        $product = new Product();
        $tags = new Tag();

        return view('dashboard.products.create', compact('product', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:products,name'],
            'store_id' => ['required', 'int', 'exists:stores,id'],
            'category_id' => ['nullable', 'int', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'compare_price' => ['nullable', 'numeric'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status' => 'in:active,draft,archvied',
            // 'tags' => 'string',
        ]);
        $data = $request->except('image');
        $data['slug'] = $this->generateUniqueSlug($request->post('name'));
        $data['image'] = $this->uploadImage($request);
        $product = Product::create($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $image = $file->store('uploads', [
                    'disk' => 'public'
                ]);
                $product->images()->create([
                    'image' => $image,
                ]);
            }
        }

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('view', $product);

        return view('dashboard.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        $tags = implode(',', $product->tags()->pluck('name')->toArray()); // Convert to string 

        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100', 'unique:products,name,' . $product->id],
            'store_id' => ['required', 'int', 'exists:stores,id'],
            'category_id' => ['nullable', 'int', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric'],
            'compare_price' => ['nullable', 'numeric'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status' => 'in:active,draft,archvied',
            // 'tags' => 'string',
        ]);

        $oldImage = $product->image;

        $data = $request->except('image');
        $data['slug'] = $this->generateUniqueSlug($request->post('name'), $product->id);

        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }
        $product->update($data);

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $image = $file->store('uploads', [
                    'disk' => 'public'
                ]);
                $product->images()->create([
                    'image' => $image,
                ]);
            }
        }
        if ($oldImage && $new_image && $oldImage !== $new_image) {
            Storage::disk('public')->delete($oldImage);
        }

        // $product->update($request->except('tags'));

        // $tags = json_decode($request->post('tags'));
        // $tag_ids = [];

        // $saved_tags = Tag::all();

        // foreach ($tags as $item) {
        //     $slug = Str::slug($item->value);
        //     $tag = $saved_tags->where('slug', $slug)->first();
        //     if (!$tag) {
        //         $tag = Tag::create([
        //             'name' => $item->value,
        //             'slug' => $slug,
        //         ]);
        //     }
        //     $tag_ids[] = $tag->id;
        // }

        // $product->tags()->sync($tag_ids);


        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);
        $product->delete();

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Deleted Done!');
    }

    public function export(Request $request)
    {
        $query = $this->query($request);

        $export = new ProductsExport();
        $export->setQuery($query);
        return Excel::download($export, 'products.xlsx');
    }

    public function importView()
    {
        return view('dashboard.products.importView');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xls,xlsx,csv'],
        ]);

        Excel::import(new ProductsImport, $request->file('file')->path());

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product Imported successfully!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image'); // UploadedFile Object

        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }

    protected function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $baseSlug = $slug;
        $counter = 1;

        while (
            Product::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '<>', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

}
