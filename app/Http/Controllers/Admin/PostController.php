<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Seo;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $post = Post::select('id','title','slug',)->get();  
        $data = [
            'posts' => $post
        ];
        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [];
        $category = Category::all()->pluck('name', 'id');
        $tag = Tag::pluck('name', 'id');
        $data = [
            'categories' => $category,
            'tags' => $tag
        ];
        // dd($data);
        return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required',
            'categories' => 'required|array|exists:categories,id',
            'tags' => 'required|array|exists:tags,id',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $author=Author::where('user_id',auth()->user()->id)->first();
        $post = Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'author_id' => $author->id,
            'publication_date'=>Carbon::now()->format('Y-m-d '),

        ]);
           Seo::create([
            'seo_type'=>'post',
            'parent_id'=>$post->id,
            'schema'=>$request->schema,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'meta_keywords'=>$request->meta_keywords
        ]);
        foreach ($request->tags as $tag) {
            PostTag::create([
                'post_id' => $post->id,
                'tag_id' => $tag
            ]);
        }
        foreach ($request->categories as $category) {
            PostCategory::create([
                'post_id' => $post->id,
                'category_id' => $category
            ]);
        }

        if ($request->hasFile('image')) {
            $request->image->move(public_path('images/posts'), $request->image->getClientOriginalName());
            Image::create([
                'name' => $request->image->getClientOriginalName(),
                'parent_id' => $post->id,
                'parent_type' => 'Post',
                'alt' => $request->title
            ]);
        }
        return redirect()->route('posts.index', ['success' => 'Post created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        $category = Category::all()->pluck('name', 'id');
        $tag = Tag::pluck('name', 'id');
        $data = [
            'post' => $post,
            'categories' => $category,
            'tags' => $tag
        ];
        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::find($id);
        $category = Category::all()->pluck('name', 'id');
        $tag = Tag::pluck('name', 'id');
        $seo=Seo::where('parent_id',$post->id)->where('seo_type','post')->first();
        $image=Image::where('parent_id',$post->id)->where('parent_type','Post')->first();
        if(!$post){
            return redirect()->route('posts.index',['error'=>'Post not found']);
        }

        $data = [
            'post' => $post,
            'categories' => $category,
            'tags' => $tag,
            'seo' => $seo,
            'image' => $image
        ];
        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post=Post::find($id);
        $seo=Seo::where('parent_id',$post->id)->where('seo_type','post')->first();
        $image=Image::where('parent_id',$post->id)->where('parent_type','Post')->first();
        $postTag=PostTag::where('post_id',$post->id)->get();
        $postCategory=PostCategory::where('post_id',$post->id)->get();
        if(!$post){
            return redirect()->route('posts.index',['error'=>'Post not found']);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required',
            'categories' => 'required|array|exists:categories,id',
            'tags' => 'required|array|exists:tags,id',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $author=Author::where('user_id',auth()->user()->id)->get()->first();
        $post->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'author_id' => $author->id,

        ]);
        $seo->update([
            'seo_type'=>'post',
            'parent_id'=>$post->id,
            'schema'=>$request->schema,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'meta_keywords'=>$request->meta_keywords
        ]);
        foreach($$postCategory as $category){
            $category->delete();
        }

        foreach($$postTag as $tag){
            $tag->delete();
        }
        foreach ($request->tags as $tag) {
            $tag->create([
                'post_id' => $post->id,
                'tag_id' => $tag
            ]);
        }
        foreach ($request->categories as $category) {
            PostCategory::updateOrCreate([
                'post_id' => $post->id,
                'category_id' => $category
            ]);
        }
        // delete image from folder
        if($image){
            unlink(public_path('images/posts/'.$image->name));
            $image->delete();
        }
        if ($request->hasFile('image')) {
            $request->image->move(public_path('images/posts'), $request->image->getClientOriginalName());
            Image::updateOrCreate([
                'name' => $request->image->getClientOriginalName(),
                'parent_id' => $post->id,
                'parent_type' => 'Post',
                'alt' => $request->title
            ]);
        }
        return redirect()->route('posts.index', ['success' => 'Post created successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post=Post::find($id);
        $postCategory=PostCategory::where('post_id',$post->id)->get();
        $postTag=PostTag::where('post_id',$post->id)->get();
        foreach($$postCategory as $category){
            $category->delete();
        }
        foreach($$postTag as $tag){
            $tag->delete();
        }
        $seo=Seo::where('parent_id',$post->id)->where('seo_type','post')->first();
        if($seo){
            $seo->delete();
        }
        $image=Image::where('parent_id',$post->id)->where('parent_type','Post')->first();
        if($image){
            unlink(public_path('images/posts/'.$image->name));
            $image->delete();
        }
        if(!$post){
            return redirect()->route('posts.index',['error'=>'Post not found']);
        }
        $post->delete();
        return redirect()->route('posts.index',['success'=>'Post deleted successfully']);
    }
}
