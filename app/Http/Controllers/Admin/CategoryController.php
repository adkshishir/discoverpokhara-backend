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
        $category=Category::all();
        $data=[
            'category'=>$category,
            
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'schema' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('admin/categories/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        $category=Category::create([
            "name"=>$request->name,
            "slug"=>$request->slug,
        ]);
            //    before save it into the database first save this into the folder
             $request->image->move(public_path('images'),$request-> image->getClientOriginalName());
        Image::create([
            "name"=>$request->image->getClientOriginalName(),
             "parent_id"=>$category->id,
             "parent_type"=>'Category',
             'alt' => 'Auth Logo',
        ]);
       
        Seo::create([
            "seo_type"=>"category",
            "parent_id"=>$category->id,
            "meta_title"=>$request->meta_title,
            "meta_description"=>$request->meta_description,
            "meta_keywords"=>$request->meta_keywords,
            'schema' => $request->schema
        ]);
        $data['category']=$category;
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
    public function edit(string $id)
    { 
        $category=Category::find($id);
        if(!$category){
            return redirect()->route('categories.index',['error'=>'Category not found']);
        }
        $data=[
            'category'=>$category
        ];
        return view('categories.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category=Category::find($id);
        // check the id and the type of the seo
        $seo=Seo::where('parent_id',$category->id)->where('seo_type','category')->first();
        $image=Image::where('parent_id',$category->id)->where('parent_type','Category')->first();
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
        ]);

        if($request->hasFile('image')){
            // update the image in the folder or update the image in the folder
              $image->update([
                 "name"=>$request->image->getClientOriginalName(),
                 "parent_id"=>$category->id,
                 "parent_type"=>'Category',
                 'alt' => 'Auth Logo',
            ]);
        }
        $seo->update([
            "seo_type"=>"category",
            "parent_id"=>$category->id,
            "meta_title"=>$request->meta_title,
            "meta_description"=>$request->meta_description,
            "meta_keywords"=>$request->meta_keywords
        ]);
         
        return redirect()->route('admin.categories.index',['success'=>'Category updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        if(!$category){
            return redirect()->route('admin.categories.index',['error'=>'Category not found']);
        }
        $category->delete();
        return redirect()->route('admin.categories.index',['success'=>'Category deleted successfully']);
    }
}
