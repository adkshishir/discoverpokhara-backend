@extends('layouts.app')

@section('title', 'Edit Category')
@section('sub_header', 'Category')
@section('content')
{{-- @dd($category) --}}
<div class="container h-full w-full">
    <div class="container pt-5 rounded ">
        <form class="pt-5 rounded form bg-white p-3" enctype="multipart/form-data" action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <h3>SEO</h3>
              <div class="row">
                   <div class="col-md-6">
                    <x-adminlte-input value="{{$category->seo->meta_title}}" name="meta_title" label="Meta Title" placeholder="Enter meta title" fgroup-class=""
                    >
                    <x-slot name='buttomsSlot'>
                      @if($errors->has('meta_title'))
                      <div id="meta_title_error" class="text-danger">{{ $errors->first('meta_title') }}</div>
                    @endif
                    </x-slot>
                    </x-adminlte-input>
                 
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{$category->seo->meta_description}}" name="meta_description" label="Meta Description" placeholder="Enter meta description" fgroup-class=""
                        >
                        <x-slot name='buttomsSlot'>
                          @if($errors->has('meta_description'))
                          <div class="text-danger">{{ $errors->first('meta_description') }}</div>
                        @endif
                        </x-slot>
                        </x-adminlte-input>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ $category->seo->meta_keywords }}" name="meta_keywords" label="Meta Keywords" placeholder="Enter meta keywords" fgroup-class=""
                         />
                </div>
                <div class="col-md-6">
                  <x-adminlte-input value="{{ $category->seo->cannonical_url}}" name="cannonical_url" label="Cannonical Url" placeholder="Enter cannonical Url" fgroup-class=""
                    />

              </div>
               <div class="col-md-12">
                  <label for="schema">Schema</label>
                  <textarea class="form-control" name="schema" rows="7" label="schema" value="{{$category->seo->schema}}"
                    placeholder="Write Schema...">{{ $category->seo->schema }}</textarea>
                  @if($errors->has('meta_schema'))
                  <div class="text-danger">{{ $errors->first('meta_schema') }}</div>
                  @endif
                </div>
            </div>
            <div class="row">
                  <div class="col-md-6">
                    <x-adminlte-input value="{{ $category->name}}" name="name" label="Name" placeholder="Enter name" fgroup-class=""
                     >
                     <x-slot  name='buttomsSlot'>    
                      <div id="title_error" class="text-danger">this is error</div>
                    </x-slot>
                    
                    </x-adminlte-input>

                  </div>
                  <div class="col-md-6">
                    <x-adminlte-input value="{{ $category->slug }}" name="slug" label="Slug" placeholder="Slug..." fgroup-class=""
                     />

                  </div>
                  <div class="col-md-12">
                    <label for="description">Description</label>
                   <textarea class="form-control" name="description" rows="7" label="schema" value="{{$category->description}}" placeholder="Write Description..." >{{ $category->description }}</textarea>
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
                        <input class="form-control form-control-md" id="image" type="file" placeholder="Choose a file..." value=""
                            name="image">
                      </div>
                  </div>


            </div>
           
            <x-adminlte-button onclick="return validateForm()" class="btn-flat  mt-4" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save " />
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
                if(e.target.result!=''){
                    imagepreview.src = e.target.result;
                }
            }
            reader.readAsDataURL(this.files[0]);
        });

    

    function validateForm(){
            //  get the form data
            // there are many ways to get this data using jQuery (you can use the class or id also)
            var formData = {
                'name'              : $('input[name=name]').val(),
                'slug'              : $('input[name=slug]').val(),
                'description'       : $('textarea[name=description]').val(),
                'meta_title'        : $('input[name=meta_title]').val(),
                'meta_description'  : $('input[name=meta_description]').val(),
                'meta_keywords'     : $('input[name=meta_keywords]').val(),
                'cannonical_url'    : $('input[name=cannonical_url]').val(),
                'schema'            : $('textarea[name=schema]').val(),
                'image'             : $('input[name=image]').val(),
            };
      

            //   if any of the above input is empty
            //   then add a 'error' class to that input
            //   else remove the 'error' class
            if(formData.name == ""){
                $('input[name=name]').addClass('error');
                $('#title_error').text('Name is required');
                return false;
            }else{
                $('input[name=name]').removeClass('error');
            }
            if(formData.slug == ""){
                $('input[name=slug]').addClass('error');
                return false;
            }else{
                $('input[name=slug]').removeClass('error');
            }
            if(formData.description == ""){
                $('textarea[name=description]').addClass('error');
                return false;
            }else{
                $('textarea[name=description]').removeClass('error');
            }
            if(formData.meta_title == ""){
                $('input[name=meta_title]').addClass('error');
                return false;
            }else{
                $('input[name=meta_title]').removeClass('error');
            }
            if(formData.meta_description == ""){
                $('input[name=meta_description]').addClass('error');
                return false;
            }else{
                $('input[name=meta_description]').removeClass('error');
            }
            if(formData.meta_keywords == ""){
                $('input[name=meta_keywords]').addClass('error');
                return false;
            }else{
                $('input[name=meta_keywords]').removeClass('error');
            }
            if(formData.cannonical_url == ""){
                $('input[name=cannonical_url]').addClass('error');
                return false;
            }else{
                $('input[name=cannonical_url]').removeClass('error');
            }
            if(formData.schema == ""){
                $('textarea[name=schema]').addClass('error');
                return false;
            }else{
                $('textarea[name=schema]').removeClass('error');
            }
            return true
          
        }
    </script>  
@endpush