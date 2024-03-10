


@extends('layouts.app')

@section('title', 'Create Category')
@section('header', 'Category')
@section('content')

<div class="container h-full w-full">
    <div class="container pt-5 rounded ">
        {{dd($post,$seo,$categories,$tags)}}
        <form class="pt-5 rounded form bg-white p-3" enctype="multipart/form-data" action="{{route('posts.update', $post->id,)}}"
            method="POST">
            @csrf
            <h3>SEO</h3>`
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input value="{{$seo->meta_title }}" name="meta_title" label="Meta Title"
                        placeholder="Enter meta title" fgroup-class="" disable-feedback />
                    @if($errors->has('meta_title'))
                    <div class="text-danger">{{ $errors->first('meta_title') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('meta_description') }}" name="meta_description"
                        label="Meta Description" placeholder="Enter meta description" fgroup-class=""
                        disable-feedback />
                    @if($errors->has('meta_description'))
                    <div class="text-danger">{{ $errors->first('meta_description') }}</div>
                    @endif
                </div>
                <div class="col-md-12">
                    <x-adminlte-input value="{{ old('meta_keywords') }}" name="meta_keywords" label="Meta Keywords"
                        placeholder="Enter meta keywords" fgroup-class="" disable-feedback />
                    @if($errors->has('meta_keywords'))
                    <div class="text-danger">{{ $errors->first('meta_keywords') }}</div>
                    @endif
                </div>
                <div class="col-md-12">
                    @php

                    @endphp
                    <x-adminlte-textarea name="schema" rows="5" label="Schema" value="{{old('schema')}}"
                        placeholder="Write Schema..." />
                    @if($errors->has('schema'))
                    <div class="text-danger">{{ $errors->first('schema') }}</div>
                    @endif

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('title') }}" name="title" label="Name" placeholder="Enter Title"
                        fgroup-class="" disable-feedback />
                    @if($errors->has('title'))
                    <div class="text-danger">{{ $errors->first('title') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('slug') }}" name="slug" label="Slug" placeholder="Slug..."
                        fgroup-class="" disable-feedback />
                    @if($errors->has('slug'))
                    <div class="text-danger">{{ $errors->first('slug') }}</div>
                    @endif
                </div>
                    @php
                    $config = [
                    "placeholder" => "Select multiple options...",
                    "allowClear" => true,
                    
                    ];
                    @endphp
                <div class="col-md-6">
                    <x-adminlte-select2  id="category" name="categories[]" label="Categories"
                        label-class="" igroup-size="sm" :config="$config" multiple>
                        <x-slot  name="prependSlot">
                            <div class="input-group-text bg-primary">
                                <i class="fas fa-tag"></i>
                            </div>
                        </x-slot>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger" />
                        </x-slot>
                        @isset($categories)
                       @foreach($categories as $id=>$value)
                        <option value="{{ $id}}">{{ $value }}</option>
                        @endforeach
                        @endisset
                    
                    </x-adminlte-select2>
                </div>
                <div class="col-md-6">
                    <x-adminlte-select2  id="tags" name="tags[]" label="Tags"
                    label-class="" igroup-size="sm" :config="$config" multiple>
                    <x-slot  name="prependSlot">
                        <div class="input-group-text bg-primary">
                            <i class="fas fa-tag"></i>
                        </div>
                    </x-slot>
                    <x-slot name="appendSlot">
                        <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger" />
                    </x-slot>
                    @isset($tags)
                   @foreach($tags as $id=>$value)
                    <option value="{{ $id}}">{{ $value }}</option>
                    @endforeach
                    @endisset
                
                </x-adminlte-select2>
                </div>
               
                <div class="col-md-12">
                    @php
                    $config = [
                    "height" => "300",
                    "toolbar" => [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                    ],
                    ]
                    @endphp
                    <x-adminlte-text-editor name="content" label="WYSIWYG Editor" label-class="" igroup-size="sm"
                        placeholder="Main Content..." :config="$config" />

                </div>

                <div class="col-md-12">
                    {{-- With label and feedback disabled --}}
                    <div>
                        <label for="image" class="form-label">Large file input example</label>
                        <input class="form-control form-control-lg" id="image" type="file" value="{{ old('image') }}"
                            name="image">
                    </div>
                    {{--
                    <x-adminlte-input-file value="{{ old('image') }}" class="w-full" fgroup-class="" name="image"
                        label="Upload file" placeholder="Choose a file..." disable-feedback /> --}}
                    @if($errors->has('image'))
                    <div class="text-danger">{{ $errors->first('image') }}</div>
                    @endif
                </div>

            </div>

            <x-adminlte-button class="btn-flat  mt-4" type="submit" label="Submit" theme="success"
                icon="fas fa-lg fa-save " />
        </form>
    </div>
</div>
@endsection