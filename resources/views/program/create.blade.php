@extends('layouts.admin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
                    <form id="formprogram" method="POST" action="{{ route('program.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-sm-2 col-form-label ">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus maxlength="50">

                                @if ($errors->has('title'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="short_description" class="col-sm-2 col-form-label ">{{ __('Deskripsi Singkat') }}</label>

                            <div class="col-md-6">
                                <textarea id="short_description" required maxlength="140" name="short_description" class="form-control{{ $errors->has('short_description') ? ' is-invalid' : '' }}">{!! old('short_description') !!}</textarea>

                                @if ($errors->has('short_description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('short_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="detail" class="col-md-2 col-form-label ">{{ __('Detail') }}</label>

                            <div class="col-md-6">
                                <textarea id="detail" name="detail" class="form-control{{ $errors->has('detail') ? ' is-invalid' : '' }}">{!! old('detail') !!}</textarea>
                                
                                @if ($errors->has('detail'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('detail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>     
                        <div class="form-group row">
                            <label for="location" class="col-md-2 col-form-label ">{{ __('Location') }}</label>

                            <div class="col-md-6">
                                <input id="location" type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" required>

                                @if ($errors->has('location'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="targetdonation" class="col-md-2 col-form-label ">{{ __('Target Donation') }}</label>

                            <div class="col-md-6">
                                <input id="targetdonation" type="number" class="form-control{{ $errors->has('targetdonation') ? ' is-invalid' : '' }}" name="targetdonation" required>

                                @if ($errors->has('targetdonation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('targetdonation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                                <label for="jenis" class="col-md-2 col-form-label ">{{ __('Jenis') }}</label>    
                                <div class="col-md-6">
                                    <select id="jenis" type="text" class="form-control{{ $errors->has('jenis') ? ' is-invalid' : '' }}" name="jenis"   required>
                                        <option value="" disabled selected>Select your option</option>
                                        <option value="A">Amal</option>
                                        <option value="Z">Zakat</option>
                                    </select>
                                    @if ($errors->has('jenis'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('jenis') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        <div class="form-group row">
                            <label for="category" class="col-md-2 col-form-label ">{{ __('Category') }}</label>
                            <div class="col-md-6">
                            <select id="category" type="text" class="form-control" name="category">
                              
                            </select>
                            @if ($errors->has('category'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </span>
                            @endif
                        </div>
                        </div>
                        <div class="form-group row">
                            <label for="dateend" class="col-md-2 col-form-label ">{{ __('Date End') }}</label>

                            <div class="col-md-6">
                                <input id="dateend" type="date" class="form-control{{ $errors->has('dateend') ? ' is-invalid' : '' }}" name="dateend" required>

                                @if ($errors->has('dateend'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('dateend') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <h2>Gambar Cover</h2>
                        </div>
                            <div class="col-md-6">
                                <input id="gambarcoveri" class="form-control" type="file" name="gambarcover">
                            </div>
                                <img id="gambarcoverh" style="margin-top:5px;max-height:100px;">
                            <div class="form-group row">
                                <h2>Gambar lainya</h2>
                            </div>
                        <div class="form-group row">
                                    <button id="tambahgmbr" class="btn btn-primary">
                                            Tambah Gambar
                                        </button> 
                            </div>
                            <div class="listgambar">


                            </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>                               
                            </div>
                        </div>
                    </form>
        </div>
    </div>
@endsection

@section('js')
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $( document ).ready(function() {
        var options = {
          filebrowserImageBrowseUrl: '/uploadfile?type=Images',
          filebrowserImageUploadUrl: '/uploadfile/upload?type=Images&_token={{csrf_token()}}',
          filebrowserBrowseUrl: '/uploadfile?type=Files',
          filebrowserUploadUrl: '/uploadfile/upload?type=Files&_token={{csrf_token()}}'
        };
        $('#gambarcover').filemanager('image');
        CKEDITOR.replace('detail', options);        
        
        $('.listgambar').on('click', '.hapus-gambar',function(e) {
            e.preventDefault();
            $(this).parent().parent().remove();
        })
        var jmlgambar = 0;
        $('#tambahgmbr').click(function(e){
            e.preventDefault();
            jmlgambar++;
            $('.listgambar').append(
                `
                <div class="group-gambar">
                <div class="form-group row input-group col-md-6 group-gambar_` + jmlgambar +`" style="margin-top:10px;">
                            <button class="btn btn-danger hapus-gambar">Hapus</button>
                            <span class="input-group-btn">
                              <a href="#" id="gambar_` + jmlgambar +`" data-input="gambari_` + jmlgambar +`" data-preview="gambarh_` + jmlgambar +`" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                              </a>
                            </span>
                            <input id="gambari_` + jmlgambar +`" class="form-control" type="text" name="gambar_` + jmlgambar +`">
                          </div>
                          <img id="gambarh_` + jmlgambar +`" style="margin-top:5px;max-height:100px;">
                </div>
                `
            );
            $('#gambar_' + jmlgambar).filemanager('image');
        });


        var data = [
            @foreach($kategori as $item)
            {
                id: '{{$item->id}}',
                text: '{{$item->category_name}}',
            },    
            @endforeach        
        ];
        
        $('#jenis').change(function(e) {
           
            var item = data.filter(function(d) {
                return d.id.substr(0,1) == $('#jenis').val();
            });
            console.log(item);
            $("#category").select2().empty();
            $("#category").select2({
                data: item
            });

        });
        
        
    });
</script>    
@endsection
