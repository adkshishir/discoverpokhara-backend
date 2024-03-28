<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Seo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::select('id','name','slug')->get();
        $data=[
            'categories'=>$categories,   
        ];
       return view('admin.categories.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'schema' => 'required',
            'cannonical_url' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect('admin/categories/create')
                        ->withErrors($validator)
                        ->withInput($request->all());
        }
        $category=Category::create([
            "name"=>$request->name,
            "slug"=>$request->slug,
            'image' => $request->image->getClientOriginalName(),
            'description' => $request->description,

        ]);
        
        if($request->hasFile('image')){
            $category->addMediaFromRequest('image')->toMediaCollection('categories');
           }
        Seo::create([
            "category_id"=>$category->id,
            "meta_title"=>$request->meta_title,
            "meta_description"=>$request->meta_description,
            "meta_keywords"=>$request->meta_keywords,
            'schema' => $request->schema,
            'cannonical_url' => $request->cannonical_url,

        ]);
       return redirect()->route('categories.index',['success'=>'Category created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $category=Category::find($id);
            $data=[
               'category'=>$category
           ];
           return view('categories.show',$data);
        }
        catch(Exception $e){
            return redirect()->route('categories.index',['error'=>$e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {     
    // get category with seo and the images
      $image=$category->getMedia('categories')->first();
        if(!$category){
            return redirect()->route('categories.index',['error'=>'Category not found']);
        }
        $data=[
            'category'=>$category,
            'image'=>$image
        ];
        return view('admin.categories.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {  
        if(!$category){
            return redirect()->route('categories.index',['error'=>'Category not found']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'schema' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/category/'.$category->id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
        $category->update([
            "name"=>$request->name,
            "slug"=>$request->slug,
            'description' => $request->description,
        ]);
       $seo=Seo::where('category_id',$category->id)->first();
       $seo->update([
        "meta_title"=>$request->meta_title,
        "meta_description"=>$request->meta_description,
        "meta_keywords"=>$request->meta_keywords,
        'schema' => $request->schema,
        'cannonical_url' => $request->cannonical_url,
    ]);
        if($request->image){
            $category->clearMediaCollection('categories');
            $category->addMediaFromRequest('image')->toMediaCollection('categories');
        }
        return redirect()->route('categories.index',['success'=>'Category updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if(!$category){
            return redirect()->route('admin.categories.index',['error'=>'Category not found']);
        }
        $category->delete();
        return redirect()->route('admin.categories.index',['success'=>'Category deleted successfully']);
    }
}
