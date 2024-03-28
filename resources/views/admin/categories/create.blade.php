@extends('layouts.app')

@section('title', 'Create Category')
@section('header', 'Category')
@section('content')


<div class="container h-full w-full">
    <div class="container pt-5 rounded ">
        <form id="form" class="pt-5 rounded form bg-white p-3" enctype="multipart/form-data" action="{{ route('categories.store') }}" method="POST">
            @csrf
            <h3>SEO</h3>
          
            <div class="row">
                   <div class="col-md-6">
                     <x-adminlte-input id="meta_title" value="{{ old('meta_title') }}" name="meta_title" label="Meta Title" placeholder="Enter meta title" fgroup-class=""/>
                    {{-- <div id="meta_title_error" class="text-danger"></div> --}}
                 
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('meta_description') }}" name="meta_description" label="Meta Description" placeholder="Enter meta description" fgroup-class=""
                        >
                        {{-- <x-slot name='buttomsSlot'>
                          @if($errors->has('meta_description'))
                          <div id="meta_description_error" class="text-danger">{{ $errors->first('meta_description') }}</div>
                        @endif
                        </x-slot> --}}
                        </x-adminlte-input>
                </div>
                <div class="col-md-6">
                    <x-adminlte-input value="{{ old('meta_keywords') }}" name="meta_keywords" label="Meta Keywords" placeholder="Enter meta keywords" fgroup-class=""
                         />
                </div>
                <div class="col-md-6">
                  <x-adminlte-input value="{{ old('cannonical_url') }}" name="cannonical_url" label="Cannonical Url" placeholder="Enter cannonical Url" fgroup-class=""
                    />
              </div>
                <div class="col-md-12">
                 <x-adminlte-textarea id="schema" name="schema" rows='7' class="form-control" label="schema" value="{{old('schema')}}" placeholder="Write Schema..." />
                </div>
            </div>
            <div class="row">
                  <div class="col-md-6">
                  
                    <x-adminlte-input value="{{ old('name') }}" name="name" label="Name" placeholder="Enter name" fgroup-class=""
                     > <x-slot name="bottomSlot">
                      <span id="title_error" class="text-sm text-danger">
                        
                      </span>
                  </x-slot>
                    </x-adminlte-input>

                  </div>
                  <div class="col-md-6">
                    <x-adminlte-input value="{{ old('slug') }}" name="slug" label="Slug" placeholder="Slug..." fgroup-class=""
                     />

                  </div>
                  <div class="col-md-12">
                    <x-adminlte-textarea id="description" name="description" rows="4" label="description" value="{{old('description')}}" placeholder="Write Schema..." />
                    {{-- <textarea name="description" rows="4" label="description" value="{{old('description')}}" placeholder="Write Schema..." >{{old('description')}}</textarea> --}}
                   </div>
                 
                  <div class="col-md-12">
                    <div class="container">
                      <img id="imagepreview" class="w-25" src="{{old('image')}}" alt="">
                    </div>

                      <div>
                        <label for="formFile" class="form-label mt-2">Upload </label>
                          
                        <input class="form-control form-control-md" id="image" type="file" placeholder="Choose a file..." value="{{ old('image') }}"
                            name="image">
                      </div>
                  </div>


            </div>
           
            <x-adminlte-button id="submit-button" onclick="return validateForm()" class="btn-flat  mt-4" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save " />
        </form>
    </div>
</div>
@endsection

@push('js')
  <script>
        $('#image').on('change', function() {
          if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#imagepreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
          }
        });
        $(document).ready(function() {
          $('#schema').val(sessionStorage.getItem('schema'));
          $('#description').val(sessionStorage.getItem('description'));
        });
        $('#schema').on('input', function() {
          sessionStorage.setItem('schema', $(this).val());
        });
        $('#description').on('input', function() {
          sessionStorage.setItem('description', $(this).val());
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
            if(formData.image == ""){
                $('input[name=image]').addClass('error');
                return false
            }else{
                $('input[name=image]').removeClass('error');
            }
            return true
          
        }
    </script>  
@endpush
@push('css')
    <style>
        .error {
            border: 1px solid red;
        }
    </style>
@endpush