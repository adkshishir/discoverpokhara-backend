<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Seo;
use App\Models\Tag;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::select('id', 'title', 'slug')->get();
        $data=[
            'tags'=>$tags,
           
        ];
        return view('admin.tags.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data=[];
        $categories = Category::pluck('title', 'id');
        // dd($categories);
        $data=[
            'categories'=>$categories
        ];
        return view('admin.tags.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'title' => 'required',
            'category_id' => 'required',
            // 'slug' => 'required|unique:categories,slug',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'description' => 'required',
            // 'meta_title' => 'required',
            // 'meta_description' => 'required',
            // 'meta_keywords' => 'required',
            // 'schema' => 'required',
            // 'cannonical_url' => 'required|string|max:255',
        ]);
          if($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
          }
       $tag= Tag::create([
            'title' => $request->title,
            'slug'=>$request->slug,
            'category_id'=>$request->category_id,
            'description' => $request->description,
        ]);
        Seo::create([
            'tag_id'=>$tag->id,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'schema' => $request->schema,
            'cannonical_url' => $request->cannonical_url
        ]);
        if($request->hasFile('image')){
          $tag->addMediaFromRequest('image')->toMediaCollection('tags');
       }
        return redirect()->route('tags.index',['success'=>'Tag created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    { 

        $data=[
        'tag'=>$tag
        ];
        return view('admin.tags.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $categories = Category::pluck('title', 'id');
        if(!$tag){
            return redirect()->route('admin.tags.index',['error'=>'Tag not found']);
        }
        
        $data=[
            'tag'=>$tag,
            'image'=>$tag->getMedia('tags')->first(),
            'categories'=>$categories
        ];
        return view('admin.tags.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        if(!$tag){
            return redirect()->route('admin.tags.index',['error'=>'Tag not found']);
        }
        $validator = Validator::make($request->all(), [
            // 'name' => 'required',
            'category_id' => 'required',
            // 'slug' => 'required',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'description' => 'required',
            // 'meta_title' => 'required',
            // 'meta_description' => 'required',
            // 'meta_keywords' => 'required',
            // 'schema' => 'required',
            // 'cannonical_url' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('admin/tags/'.$tag->id.'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }
     
        $tag->update([
            'title' => $request->title,
            'slug'=>$request->slug,
            'category_id'=>$request->category_id,
            'description' => $request->description,
        ]);
        Seo::where('tag_id',$tag->id)->update([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'schema' => $request->schema,
            'cannonical_url' => $request->cannonical_url
        ]);
        if($request->hasFile('image')){
           $tag->clearMediaCollection('tags');
           $tag->addMediaFromRequest('image')->toMediaCollection('tags');
        }
        return redirect()->route('tags.index',['success'=>'Tag updated successfully']);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag=Tag::find($id);
        if(!$tag){
            return redirect()->route('admin.tags.index',['error'=>'Tag not found']);
        }
        $tag->delete();
        return redirect()->route('admin.tags.index',['success'=>'Tag deleted successfully']);
    }
}
