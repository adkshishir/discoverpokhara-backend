<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
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
        $tags=Tag::all();
        $data=[
            'tags'=>$tags
        ];
        return view('admin.tags.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $validatedata=$request->validate([
        //     'name'=>'required',
        //     'slug'=>'required|unique:tags,slug',
        //     'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'meta_title'=>'required',
        //     'meta_description'=>'required',
        //     'meta_keywords'=>'required'
        // ]);
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required|unique:tags,slug',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'meta_title'=>'required',
            'meta_description'=>'required',
            'meta_keywords'=>'required'
        ]);
          if($validator->fails()){
              return redirect()->back()->withErrors($validator)->withInput();
          }
        Tag::create([
            'name'=>$request->name,
            'slug'=>$request->slug
        ]);

        $request->image->move(public_path('images'),$request->image->getClientOriginalName());
        Image::create([
            'name'=>$request->image->getClientOriginalName(),
            'parent_id'=>Tag::latest()->first()->id,
            'parent_type'=>'Tag',
            'alt'=>$request->name
        ]);
        return redirect()->route('tags.index');
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
    public function edit(string $id)
    {
        $tag=Tag::find($id);
        if(!$tag){
            return redirect()->route('admin.tags.index',['error'=>'Tag not found']);
        }
        $data=[
            'tag'=>$tag
        ];
        return view('admin.tags.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
