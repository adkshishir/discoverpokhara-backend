@extends('layouts.app')

@section('title', 'Create Posts')
@section('header', 'Post')
@section('content')


<div class="alert-container float-right  top-0 end-0 " id="alert"></div>
<div class="container h-full w-full">
    <div class="container  pt-5 rounded ">
        <div class="btn-group m-2 p-2 gap-2 bg-white">
            <button onclick="showGeneral()" class="btn btn-primary">General</button>
            <button onclick="showSeo()" class="btn btn-primary">SEO</button>
        </div>
        @php

        @endphp

        <form class="pt-5 rounded form bg-white p-3" enctype="multipart/form-data" action="{{ route('posts.store') }}"
            method="POST">
            @csrf
            <div id="seo" class="row">
                <h3 class="col-md-12">SEO</h3>
                <div class="col-md-6">
                    <x-adminlte-input id="meta_title" value="{{ old('meta_title') }}" name="meta_title"
                        label="Meta Title" placeholder="Enter meta title" fgroup-class="">
                        <x-slot name="bottomSlot">
                            <span id="meta_title_error" class="text-sm text-danger">

                            </span>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('meta_description') }}" name="meta_description"
                        label="Meta Description" placeholder="Enter meta description" fgroup-class="">
                        <x-slot name="bottomSlot">
                            <span id="meta_description_error" class="text-sm text-danger">
                            </span>
                        </x-slot>
                    </x-adminlte-input>

                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('meta_keywords') }}" name="meta_keywords" label="Meta Keywords"
                        placeholder="Enter meta keywords" fgroup-class="">
                        <x-slot name="bottomSlot">
                            <span id="meta_keywords_error" class="text-sm text-danger">
                            </span>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('cannonical_url') }}" name="cannonical_url" label="Cannonical Url"
                        placeholder="Enter cannonical Url" fgroup-class="">
                        <x-slot name="bottomSlot">
                            <span id="cannonical_url_error" class="text-sm text-danger">
                            </span>
                        </x-slot>
                    </x-adminlte-input>
                </div>
                <div class="col-md-12">
                    @php

                    @endphp
                    <x-adminlte-textarea name="schema" rows="5" label="Schema" value="{{old('schema')}}"
                        placeholder="Write Schema...">{{old('schema')}}</x-adminlte-textarea>

                </div>
            </div>
            <div id="general" class="row">
                <h3 class="col-md-12">General</h3>

                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('title') }}" name="title" label="Name" placeholder="Enter Title"
                        fgroup-class="">
                        <x-slot name="bottomSlot">
                            <span id="title_error" class="text-sm text-danger">

                            </span>
                        </x-slot>
                    </x-adminlte-input>

                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('slug') }}" name="slug" label="Slug" placeholder="Slug..."
                        fgroup-class="">
                        <x-slot name="bottomSlot">
                            <span id="slug_error" class="text-sm text-danger">

                            </span>
                        </x-slot>
                    </x-adminlte-input>


                </div>
                @php
                $config = [
                "placeholder" => "Select multiple options...",
                "allowClear" => true,

                ];
                @endphp
                <div class="col-md-6">
                    <x-adminlte-select2 id="Tag" name="category_id" label="Category" label-class="" igroup-size="sm"
                        :config="$config">
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-primary">
                                <i class="fas fa-tag"></i>
                            </div>
                        </x-slot>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger" />
                        </x-slot>
                        <x-slot name="bottomSlot">
                            <span class="text-sm text-danger" id="category_id_error"></span>
                        </x-slot>
                        @if(old('category_id'))
                        <option value="{{ old('category_id') }}">{{ $categories[old('category_id')] }}</option>
                        @else
                        <option value="">Select Category</option>
                        @endif
                        @isset($categories)
                        @foreach($categories as $id=>$value)
                        <option value="{{ $id}}">{{ $value }}</option>
                        @endforeach
                        @endisset

                    </x-adminlte-select2>

                </div>
                <div class="col-md-6">
                    <x-adminlte-select2 id="tags" name="tags[]" label="Tags" label-class="" igroup-size="sm"
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
                        <div class="form-group w-full">
                            <x-adminlte-input class="col-12" name='heads[]' label="Header" placeholder="Enter header" />
                            <x-adminlte-text-editor class="col-12" id="content1" name="contents[]" rows='7'
                                label="Content" label-class="" igroup-size="sm" placeholder="Main Content..."
                                :config="$config" />
                        </div>

                        <div id="section" class="w-100 row container m-5 rounded p-2 mx-auto special-section"
                            style="background-color: aliceblue">
                            <h3 class="col-12">Special Section</h3>
                            <button type="button" id="add-section" class="btn col-12  add-section">
                                <span class="btn btn-primary">Add Section</span></button>
                        </div>
                        <button id="add-more" class=" float-right col-2 btn add-more mx-2 " type="button">
                            <span class="btn btn-primary">Add More</span></button>
                    </div>

                </div>

                <div class="col-md-12">
                    <img id="imagepreview" class="w-25" style="max-height: 200px;object-fit: cover" src="" alt="">
                    <div>
                        <label for="image" class="form-label">Image</label>
                        <input class="form-control form-control-md" id="image" type="file" value="{{ old('image') }}"
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

            <x-adminlte-button onclick="return validateForm()" id="submit-button" id="submit-button"
                class="btn-flat rounded mt-4" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save " />
        </form>
    </div>
</div>
@endsection

@push('js')

<script>
    // set image preview on change #image

    const imagepreview = document.getElementById('imagepreview');
        $('#image').on('change', function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                if(e.target.result!=''){
                    imagepreview.src = e.target.result;
                }
            }
            reader.readAsDataURL(this.files[0]);
        });
        
    let contentSection=[]
    $(document).ready(function() {
     $('#submit-button').text('Next')
    })
  function showGeneral(){
    $('#general').css({display:'flex'});
    $('#seo').css({display:'none'});
    $('#submit-button').text('Next')
  }
  function showSeo(){
    $('#seo').css({display:'flex'});
    $('#general').css({display:'none'});
  }
  $(document).ready(function() {
    $('#general').css({display:'flex'});
    $('#seo').css({display:'none'});
    //  count 0 is aleady present in html so count must be start with 1
    let count=1;
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
                                <span class="btn btn-primary">Add  Section</span></button>
                        </div>
                </div>
            `
                  
            $('#add-more').before(inputGroup);
                // Apply configuration to the newly added text editor
                let newEditorConfig = {
                    "height": "300",
                    "width": "100%",
                    "toolbar": [
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
        $(this).closest('.form-group').remove();
    });

    $(document).on('click', '.remove-section', function() {
        $(this).closest('.special-section-box').remove();
    });

     
// track submit button before submit

 $(document).on('click', '.add-section', function() {
          let  sectionIndex= $(this).closest('.special-section').index()
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

                 
    })


// form validation 
     function validateForm(){
        //   return false
        if(document.getElementById("seo").style.display === "none"){
        document.getElementById("general").style.display = "none";
         document.getElementById("seo").style.display = "flex";
         $('#submit-button').text('Submit')
         return false
      }

           formData={
               'title'              : $('input[name=title]').val(),
               'slug'              : $('input[name=slug]').val(),
            //    'description'       : $('textarea[name=description]').val(),
               'meta_title'        : $('input[name=meta_title]').val(),
               'meta_description'  : $('input[name=meta_description]').val(),
               'meta_keywords'     : $('input[name=meta_keywords]').val(),
               'cannonical_url'    : $('input[name=cannonical_url]').val(),
               'schema'            : $('textarea[name=schema]').val(),
               'image'             : $('input[name=image]').val(),
               'tags'              : $('#tags').val(),
               'heads'             : $('input[name=heads]').val(),
               'contents'          : $('textarea[name=contents]').val(),
               'section-head'      : $('input[name=section_head]').val(),
               'section-description': $('input[name=section_description]').val(),
               'section-url'       : $('input[name=section_url]').val(),
               'section-image'     : $('input[name=section_image]').val(),
           }
            //  get array inputs of heads and contents
           if(formData.title == ""){
               $('input[name=title]').addClass('is-invalid');
               $('#title_error').text('Name is required');
            //    return false;
           }else{
               $('input[name=name]').removeClass('is-invalid');
               $('#title_error').text('');
           }
           if(formData.slug == ""){
               $('input[name=slug]').addClass('is-invalid');
               $('#slug_error').text('Slug is required And unique');
            //    return false;
           }else{
               $('input[name=slug]').removeClass('is-invalid');
               $('#slug_error').text('');
           }
           if(formData.description == ""){
               $('textarea[name=description]').addClass('is-invalid');
                $('#description_error').text('Description is required');
            //    return false;
           }else{
               $('textarea[name=description]').removeClass('is-invalid');
               $('#description_error').text('');
           }
           if(formData.meta_title == ""){
               $('input[name=meta_title]').addClass('is-invalid');
                $('#meta_title_error').text('Meta Title is required');
            //    return false;
           }else{
               $('input[name=meta_title]').removeClass('is-invalid');
               $('#meta_title_error').text('');
           }
           if(formData.meta_description == ""){
               $('input[name=meta_description]').addClass('is-invalid');
                $('#meta_description_error').text('Meta Description is required');
            //    return false;
           }else{
               $('input[name=meta_description]').removeClass('is-invalid');
               $('#meta_description_error').text('');
           }
           if(formData.meta_keywords == ""){
               $('input[name=meta_keywords]').addClass('is-invalid');
                $('#meta_keywords_error').text('Meta Keywords is required');
            //    return false;
           }else{
               $('input[name=meta_keywords]').removeClass('is-invalid');
               $('#meta_keywords_error').text('');
           }
           if(formData.cannonical_url == ""){
               $('input[name=cannonical_url]').addClass('is-invalid');
                $('#cannonical_url_error').text('Cannonical URL is required');
            //    return false;
           }else{
               $('input[name=cannonical_url]').removeClass('is-invalid');
               $('#cannonical_url_error').text('');
           }
           if(formData.schema == ""){
               $('textarea[name=schema]').addClass('is-invalid');
                $('#schema_error').text('Schema is required');
            //    return false;
           }else{
               $('textarea[name=schema]').removeClass('is-invalid');
               $('#schema_error').text('');
           } 
           if(formData.image == ""){
               $('input[name=image]').addClass('is-invalid');
                $('#image_error').text('Image is required');
           }else{
               $('input[name=image]').removeClass('is-invalid');
               $('#image_error').text('');
           }

           if(formData.heads == ""){
               $('input[name=heads]').addClass('is-invalid');
                $('#heads_error').text('Heads is required');
            //    return false;
           }else{
               $('input[name=heads]').removeClass('is-invalid');
               $('#heads_error').text('');
           }
           if(formData.contents == ""){
               $('textarea[name=contents]').addClass('is-invalid');
                $('#contents_error').text('Contents is required');
            //    return false;
           }else{
               $('textarea[name=contents]').removeClass('is-invalid');
               $('#contents_error').text('');
           }
                  console.log($())
           if(!formData.title||!formData.slug||!formData.meta_title||!formData.meta_description||!formData.meta_keywords||!formData.cannonical_url||!formData.schema||!formData.image){
                    // alert('All fields are required');
                       
                    let alert=`<x-adminlte-alert theme="danger" title="Danger">
                                    All fields are required!
                                    </x-adminlte-alert>`
                        //   display the alert for 2s in top right corner
                          $(alert).appendTo('.alert-container').delay(2000).queue(function() {
                              $(this).remove();
                          });

                          window.scrollTo(0,0)
                        document.getElementById("general").style.display = "flex";
                      document.getElementById("seo").style.display = "none";
                      $('#submit-button').text('Next')
                      return false
              }
     }


</script>


@endpush
@push('css')
<style>
    #alert {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 9999;
        min-width: 300px;
    }
</style>
@endpush