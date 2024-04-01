<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Content;
use App\Models\Image;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Seo;
use App\Models\SpecialSection;
use App\Models\Tag;
use App\Models\TagPost;
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
        $post = Post::select('id','title','slug')->get();  
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
        //  dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            // 'slug' => 'required|unique:posts,slug',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'slug' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'required|array|exists:tags,id',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'heads' => 'required',
            'contents' => 'required',
            'section_head'=>'array',
            'section_head.*' => 'required',
            'section_description'=>'array',
            'section_description.*' => 'required',
            'section_image'=>'array',
            'section_image.*' => 'required',
            'section_url'=>'array',
            'section_url.*' => 'required',
            
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            
        }
        
        $author=Author::where('user_id',auth()->user()->id)->first();
        $post = Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'author_id' => $author->id,
            'category_id' => $request->category_id,
            'publication_date'=>Carbon::now()->format('Y-m-d '),

        ]);
        // save image to media collection using library
        if($request->hasFile('image')){
         $post->addMediaFromRequest('image')->toMediaCollection('posts');
        }
           Seo::create([
            'post_id'=>$post->id,
            'schema'=>$request->schema,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'meta_keywords'=>$request->meta_keywords,
            'cannonical_url'=>$request->cannonical_url
        ]);
        foreach ($request->tags as $tag) {
           TagPost::create([
               'post_id' => $post->id,
               'tag_id' => $tag
           ]);
        }
        for($i=0;$i<count($request->heads);$i++){
              
          $content=  Content::create([
                'post_id' => $post->id,
                'title' => $request->heads[$i],
                'content' => $request->contents[$i]?:"-",
            ]);
              if(isset($request->section_head[$i+1])){
            foreach($request->section_head[$i+1] as $key=>$value){
                //  dd($request->section_image[$i+1][$key],$request->section_head[$i+1][$key],$request->section_description[$i+1][$key],$request->section_url[$i+1][$key],$value);
                  $special='';
                    $value!=''&& $special= SpecialSection::create([
                    'content_id'=>$content->id,
                    'name'=>$value,
                    'image_name'=>$request->section_image[$i+1][$key]?:"-",
                    'description'=>$request->section_description[$i+1][$key]?:"-",
                    'url'=>$request->section_url[$i+1][$key]?:"-",
                ]);
                // save the image into the media library
                if(isset($request->section_image[$i+1][$key])){
                    $special->addMedia($request->section_image[$i+1][$key])->toMediaCollection('special-section');
                }
            }
        }
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
       $image=$post->getMedia()->first();
        $data = [
            'post' => $post,
            'categories' => $category,
            'tags' => $tag,
            'image'=>$image
        ];
        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        try{      
        $category = Category::all()->pluck('name', 'id');
        $tag = Tag::pluck('name', 'id');
        $image=$post->getMedia("posts")->first();
        
        if(!$post){
            return redirect()->route('posts.index',['error'=>'Post not found']);
        }
        $data = [
            'post' => $post,
            'image' => $image,
            'categories' => $category,
            'tags' => $tag
        ];
        return view('admin.posts.edit', $data);
    }
    catch (\Exception $e) {
        dd($e->getMessage());
        return redirect()->route('posts.index',['error'=>'Post not found']);
    }
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // dd($post->contents);
        $seo=Seo::where('post_id',$post->id)->first();
        $tags=TagPost::where('post_id',$post->id)->get();
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required',
            'category_id' => 'required|exists:categories,id',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'heads' => 'required',
            'contents' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $author=Author::where('user_id',auth()->user()->id)->first();
          $post->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'author_id' => $author->id,
            'category_id' => $request->category_id,
            'publication_date'=>Carbon::now()->format('Y-m-d '),

        ]);
           $seo->update([
            'post_id'=>$post->id,
            'schema'=>$request->schema,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'meta_keywords'=>$request->meta_keywords,
            'cannonical_url'=>$request->cannonical_url
        ]);
        // delete previous tags
          if($request->tags&&count($request->tags)>0){
            if(count($tags)>0){
                foreach ($tags as $tag) {
                    $tag->delete();
                }
                foreach ($request->tags as $tag) {
                   TagPost::create([
                       'post_id' => $post->id,
                       'tag_id' => $tag
                   ]);
                }
              }
          }
        // delete previous contents
        foreach ($post->contents as $content) {
            $special=SpecialSection::where('content_id',$content->id)->get();
             if(count($special)>0){
                foreach($special as $value){
                    $value->delete();
                    $value->clearMediaCollection('special_sections');
                }
            }
            $content->delete();
        }
        // create new contents
        for($i=0;$i<count($request->heads);$i++){
           $cont= Content::create([
                'post_id' => $post->id,
                'title' => $request->heads[$i],
                'content' => $request->contents[$i]
            ]);
            // dd($request->section_head);
            if(isset($request->section_head[$i+1])){
                 
                foreach($request->section_head[$i+1] as $key=>$value){
                      $special='';
                        $value!=''&& $special= SpecialSection::create([
                        'content_id'=>$cont->id,
                        'name'=>$value,
                        'image_name'=>$request->section_image[$i+1][$key]?:"-",
                        'description'=>$request->section_description[$i+1][$key]?:"-",
                        'url'=>$request->section_url[$i+1][$key]?:"-",
                    ]);
                    // save the image into the media library
                    if(isset($request->section_image[$i+1][$key])){
                        $special->addMedia($request->section_image[$i+1][$key])->toMediaCollection('special-section');
                    }
                }
            }
         

        }
        if ($request->hasFile('image')) {
            $post->clearMediaCollection('posts');
            $post->addMedia($request->image)->toMediaCollection('posts');
        }
        return redirect()->route('posts.index', ['success' => 'Post created successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post=Post::find($id);
        if(!$post){
            return redirect()->route('posts.index',['error'=>'Post not found']);
        }
        $postTag=TagPost::where('post_id',$post->id)->get();

        foreach($postTag as $tag){
            $tag->delete();
        }
        $seo=Seo::where('post_id',$post->id)->first();
        if($seo){
            $seo->delete();
        }
        $image=Image::where('parent_id',$post->id)->where('parent_type','Post')->first();
        if($image){
            unlink(public_path('images/posts/'.$image->name));
            $image->delete();
        }
        $post->delete();
        return redirect()->route('posts.index',['success'=>'Post deleted successfully']);
    }
}
