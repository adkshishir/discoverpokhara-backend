@extends('layouts.app')

@section('title', 'Create Posts')
@section('header', 'Post')
@section('content')

<div class="container h-full w-full">
    <div class="container  pt-5 rounded ">
        <div class="btn-group m-2 p-2 gap-2 bg-white">
            <button onclick="showGeneral()" class="btn btn-primary">General</button>
            <button onclick="showSeo()" class="btn btn-primary">SEO</button>
        </div>
        @php


        @endphp

        <form class="pt-5 rounded form bg-white p-3" enctype="multipart/form-data"
            action="{{ route('posts.update', $post) }}" method="POST">
            @csrf
            @method('PUT')
            <div id="seo" class="row">
                <h3 class="col-md-12">SEO</h3>
                <div class="col-md-6">
                    <x-adminlte-input id="meta_title" value="{{$post->seo->meta_title }}" name="meta_title"
                        label="Meta Title" placeholder="Enter meta title" fgroup-class="" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $post->seo->meta_description }}" name="meta_description"
                        label="Meta Description" placeholder="Enter meta description" fgroup-class="" />

                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $post->seo->meta_keywords }}" name="meta_keywords" label="Meta Keywords"
                        placeholder="Enter meta keywords" fgroup-class="" />
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $post->seo->cannonical_url }}" name="cannonical_url"
                        label="Cannonical Url" placeholder="Enter cannonical Url" fgroup-class="" />
                </div>
                <div class="col-md-12">
                    @php

                    @endphp
                    <x-adminlte-textarea name="schema" rows="5" label="Schema" placeholder="Write Schema...">{{
                        $post->seo->schema }}</x-adminlte-textarea>
                    @if($errors->has('schema'))
                    <div class="text-danger">{{ $errors->first('schema') }}</div>
                    @endif

                </div>
            </div>
            <div id="general" class="row">
                <h3 class="col-md-12">General</h3>

                <div class="col-md-6">
                    <x-adminlte-input value="{{ $post->title }}" name="title" label="Name" placeholder="Enter Title"
                        fgroup-class="" />

                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('h1') }}" name="h1" label="H1" placeholder="Enter H1"
                        fgroup-class="">
                        <x-slot name="bottomSlot">
                            <span id="title_error" class="text-sm text-danger">

                            </span>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $post->slug }}" name="slug" label="Slug" placeholder="Slug..."
                        fgroup-class="" />

                </div>
                <div class="col-md-6">
                    <label for="is_published">Status</label>
                    <select name="is_published" class="form-control" id="is_published">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>

                </div>
                @php
                $config = [
                "placeholder" => "Select multiple options...",
                "allowClear" => true,

                ];
                @endphp
                <div class="col-md-6">
                    <x-adminlte-select2 id="Tag" name="category_id" label="Category *" label-class="" igroup-size="sm"
                        :config="$config">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-primary">
                                <i class="fas fa-tag"></i>
                            </div>
                        </x-slot>
                        {{-- <x-slot name="appendSlot">
                            <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger" />
                        </x-slot> --}}

                        @isset($categories)
                        @foreach($categories as $id=>$value)
                        <option value="{{ $id}}">{{ $value }}</option>
                        @endforeach
                        @endisset

                    </x-adminlte-select2>
                </div>
                <div class="col-md-6">
                    <x-adminlte-select2 id="tags" name="tags[]" label="Tags *" label-class="" igroup-size="sm"
                        :config="$config" multiple>
                        <x-slot name="prependSlot">
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
                    ['heading', ['style']],
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

                    <div class="container-fluid  w-full">
                        @foreach($post->contents as $key=>$content)
                        <div class="container-fluid">
                            <div class="form-group w-full">
                                <x-adminlte-input class="col-12" name='heads[]' label="Header"
                                    placeholder="Enter header" value="{{ $content->title }}" />
                                <x-adminlte-text-editor class="col-12" id="content{{$key}}" name="contents[]" rows='7'
                                    label="Content" label-class="" igroup-size="sm" placeholder="Main Content..."
                                    :config="$config">{{ $content->content }}</x-adminlte-text-editor>
                            </div>
                            <button class="btn btn-danger remove-input" type="button"
                                id="remove-content">Remove</button>
                            <div id="section" class="w-100 row container m-5 rounded p-2 mx-auto special-section"
                                style="background-color: aliceblue">
                                <h3 class="col-12">Special Section</h3>

                                {{-- special section start --}}

                                @isset($content->special_sections)
                                @foreach($content->special_sections as $sectionIndex=>$section)

                                <div
                                    class="container border rounded p-3 m-2 col-md-5 mx-auto bg-secondary  special-section-box">
                                    <x-adminlte-input class="col-12" value="{{$section->name}}"
                                        name="section_head[{{$sectionIndex}}][]" label="Header"
                                        placeholder="Enter section header" />
                                    <x-adminlte-input class="col-12" value="{{$section->description}}"
                                        name="section_description[{{$sectionIndex}}][]" label="Description"
                                        placeholder="Enter section description" />
                                    <x-adminlte-input class="col-12" value="{{$section->url}}"
                                        name="section_url[{{$sectionIndex}}][]" label="Url"
                                        placeholder="Enter section Url" />

                                    <x-adminlte-input type="file" class="col-12"
                                        name='section_image[{{$sectionIndex}}][]' label="Section Image"
                                        placeholder="Enter section Image" />
                                    <button type="button" class="btn btn-danger float-right remove-section">Remove
                                        Section</button>
                                </div>
                                @endforeach
                                @endisset
                                {{-- special section end --}}

                                <button type="button" id="add-section" class="btn col-12  add-section">
                                    <span class="btn btn-primary">Add Section</span></button>
                            </div>
                        </div>
                        @endforeach


                        <button id="add-more" class="col-2 float-right btn btn-primary add-more mx-2 " type="button">Add
                            More</button>

                    </div>
                </div>
                {{-- {{dd($image->getUrl())}} --}}

                <div class="col-md-12">
                    {{-- With label and feedback disabled --}}
                    <img src={{$image?->getUrl()}} alt="this is iamge" id="imagepreview" class="w-25">
                    <div>

                        <label for="image" class="form-label">Image</label>
                        <input class="form-control form-control-lg" value="{{ $image?->getUrl() }}" id="image"
                            type="file" placeholder="" name="image">
                    </div>
                    {{--
                    <x-adminlte-input-file value="{{ old('image') }}" class="w-full" fgroup-class="" name="image"
                        label="Upload file" placeholder="Choose a file..." disable-feedback /> --}}
                    @if($errors->has('image'))
                    <div class="text-danger">{{ $errors->first('image') }}</div>
                    @endif
                </div>

            </div>

            <x-adminlte-button id="submit-button" class="btn-flat rounded mt-4" type="submit" label="Submit"
                theme="success" icon="fas fa-lg fa-save " />
        </form>
    </div>
</div>
@endsection

@push('js')

<script>
    let contentSection=[]
    $(document).ready(function() {
     $('#submit-button').text('Next')
    })
  function showGeneral(){
    $('#general').css({display:'flex'});
    $('#seo').css({display:'none'});
  }
  function showSeo(){
    $('#seo').css({display:'flex'});
    $('#general').css({display:'none'});
  }
  $(document).ready(function() {
    $('#general').css({display:'flex'});
    $('#seo').css({display:'none'});

    let count=1
    $(document).on('click', '.add-more', function() {
        count=count+1
    let inputGroup = `
           <div id="cantainer${count}" class="form-group w-full">
                <x-adminlte-input class="col-12" name='heads[]' label="Header" placeholder="Enter header" />
                <x-adminlte-text-editor class="col-12" id="content${count}" name="contents[]" rows='7' label="Content" label-class=""
                    igroup-size="sm" placeholder="Main Content..." :config="$config" />

                    <button type="button" class="btn btn-danger remove-input">Remove</button>
                    <div id="section${count}" class="w-100 row container m-5 rounded p-2 mx-auto special-section" style="background-color: aliceblue">
                            <h3 class="col-12">Special Section</h3>

                            <button type="button" id="add-section" class="btn col-12 add-section">
                                <span class="btn btn-primary">Add  Section</span>
                            </button>
                     </div>
             </div>
            `

            $('#add-more').before(inputGroup);
                // Apply configuration to the newly added text editor
                let newEditorConfig = {
                    "height": "300",
                    "width": "100%",
                    "toolbar": [
                         ['heading', ['style']],
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                };
                $('#content' + count).summernote(newEditorConfig); // Assuming summernote is used as the text editor
          });
     });
    $(document).on('click', '.remove-input', function() {
        $(this).closest('.container-fluid').remove();
    });

    $(document).on('click', '.remove-section', function() {
        $(this).closest('.special-section-box').remove();
    });



    // add new section to the nearest position

 $(document).on('click', '.add-section', function() {
          let  sectionIndex= $(this).closest('.special-section').index()-1;
          console.log(sectionIndex)
                    let sectionbox=`
                           <div class="container border rounded p-3 m-2 col-md-5 mx-auto bg-secondary  special-section-box">
                                    <x-adminlte-input class="col-12" name='section_head[${sectionIndex}][]' label="Header"
                                        placeholder="Enter section header" />
                                    <x-adminlte-input class="col-12" name='section_description[${sectionIndex}][]' label="Description"
                                        placeholder="Enter section description" />
                                    <x-adminlte-input class="col-12" name='section_url[${sectionIndex}][]' label="Url"
                                        placeholder="Enter section Url" />

                                    <x-adminlte-input type="file" class="col-12" name='section_image[${sectionIndex}][]'
                                        label="Section Image" placeholder="Enter section Image" />
                                        <button type="button" class="btn btn-danger float-right remove-section">Remove Section</button>
                                </div>
                                `;
                $(this).before(sectionbox)


    });

// // track submit button before submit
// $(document).on('submit', 'form', function(e) {
// if(document.getElementById("seo").style.display === "none"){
// e.preventDefault();
// document.getElementById("general").style.display = "none";
// document.getElementById("seo").style.display = "flex";
// $('#submit-button').text('Submit')
// return false
// }
// });



</script>


@endpush
