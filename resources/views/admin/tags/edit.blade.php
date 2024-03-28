@extends('layouts.app')

@section('title', 'Edit Tag')
@section('sub_header', 'Tag')
@section('content')
{{-- @dd($tag) --}}
<div class="container h-full w-full">
    <div class="container pt-5 rounded ">
        <form class="pt-5 rounded form bg-white p-3" enctype="multipart/form-data"
            action="{{ route('tags.update', $tag) }}" method="POST">
            @csrf
            @method('PUT')
            <h3>SEO</h3>
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input value="{{$tag->seo->meta_title}}" name="meta_title" label="Meta Title"
                        placeholder="Enter meta title" fgroup-class="">
                        <x-slot name='buttomsSlot'>
                            @if($errors->has('meta_title'))
                            <div class="text-danger">{{ $errors->first('meta_title') }}</div>
                            @endif
                        </x-slot>
                    </x-adminlte-input>

                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{$tag->seo->meta_description}}" name="meta_description"
                        label="Meta Description" placeholder="Enter meta description" fgroup-class="">
                        <x-slot name='buttomsSlot'>
                            @if($errors->has('meta_description'))
                            <div class="text-danger">{{ $errors->first('meta_description') }}</div>
                            @endif
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $tag->seo->meta_keywords }}" name="meta_keywords" label="Meta Keywords"
                        placeholder="Enter meta keywords" fgroup-class="" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $tag->seo->cannonical_url}}" name="cannonical_url"
                        label="Cannonical Url" placeholder="Enter cannonical Url" fgroup-class="" />

                </div>
                <div class="col-md-12">
                    <label for="schema">Schema</label>
                    <textarea class="form-control" name="schema" rows="7" label="schema" value="{{$tag->seo->schema}}"
                        placeholder="Write Schema...">{{ $tag->seo->schema }}</textarea>
                    @if($errors->has('meta_schema'))
                    <div class="text-danger">{{ $errors->first('meta_schema') }}</div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $tag->name}}" name="name" label="Name" placeholder="Enter name"
                        fgroup-class="" />

                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $tag->slug }}" name="slug" label="Slug" placeholder="Slug..."
                        fgroup-class="" />
                </div>
                <div class="col-md-12">
                    <x-adminlte-select class="form-control" name="category_id" label="Parent">
                        <option value="{{$tag->category_id}}">{{$categories[$tag->category_id]}}</option>
                        @foreach ($categories as $key => $category)
                        @if($key != $tag->category_id)
                        <option value="{{ $key }}">{{ $category }}</option>
                        @endif
                        @endforeach
                      </x-adminlte-select>
                </div>

                <div class="col-md-12">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" rows="7" label="schema"
                        value="{{$tag->description}}"
                        placeholder="Write Description...">{{ $tag->description }}</textarea>
                    @if($errors->has('meta_schema'))
                    <div class="text-danger">{{ $errors->first('meta_schema') }}</div>
                    @endif
                </div>

                <div class="col-md-12">
                    <div class="container">
                        <img id="imagepreview" class="w-25   mt-2" style="object-fit: cover;height: 200px"   src="{{$image->getUrl()}}" alt="">
                    </div>

                    <div>
                        <label for="formFile" class="form-label mt-2">Upload </label>
                        <input class="form-control form-control-md" id="image" type="file"
                            placeholder="Choose a file..." value="{{$tag->image}}" name="image">
                    </div>
                </div>


            </div>

            <x-adminlte-button class="btn-flat  mt-4" type="submit" label="Submit" theme="success"
                icon="fas fa-lg fa-save " />
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    // get the image choosen from the id input
  
     const imagepreview = document.getElementById('imagepreview');
        $('#image').on('change', function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                imagepreview.src = e.target.result;
                sessionStorage.setItem('image', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });
</script>
@endpush