<!--Template-->
@extends('layouts.admin')

@section('content')
<div class="container">
    
            <div class="card">
                <div class="card-header">{{ __('Header') }}</div>
                <form action="{{ route('saveBookEdit') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12 row">
                                <div class="col-1 text-center">
                                    <img class="cover3" src="{{ url('storage/books/'.$book->ISBN.'.jpg') }}" id="blah">
                                </div>
                                <div class="col-6 container d-flex h-100">
                                    <input class="form-control align-self-center" type="file" id="imgInp" value = "imgInp" name='imgInp'>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 px-2">
                            <label class="col-md-1 col-form-label" for="title">Title:</label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="title" name="title" value = '{{$book->Title}}'>
                            </div>
                            <label class="col-md-1 col-form-label" for="author">Author:</label>
                            <div class="col-md-5">
                                <input class="form-control" type="text" id="author" name="author" value = '{{$book->Author}}'>
                            </div>
                        </div>
                        <div class="row mb-3 px-2">
                            <label class="col-md-1 col-form-label" for="isbn">ISBN:</label>
                            <div class="col-md-2">
                                <input class="form-control" type="text" id="isbn" name="isbn" value = '{{$book->ISBN}}'>
                            </div>
                            <label class="col-md-1 col-form-label" for="isbn">Langauge:</label>
                            <div class="col-md-2">
                                <input class="form-control" type="text" id="lang" name="lang" value = '{{$book->Language}}'>
                            </div>
                            <label class="col-md-1 col-form-label" for="year">Year:</label>
                            <div class="col-md-2">
                                <input class="form-control" type="text" id="year" name="year" value = '{{$book->Year}}'>
                            </div>
                            <label class="col-md-1 col-form-label" for="year">Price: Tk</label>
                            <div class="col-md-2">
                                <input class="form-control" type="text" id="price" name="price" value = '{{$book->Price}}'>
                            </div>
                        </div>
                        <div class="row mb-3 px-2">
                            <label class="col-md-2 col-form-label" for="isbn">Genre</label>
                            <div class="col-md-10">
                                <input placeholder = "Separate by space" class="form-control" type="text" id="genre" name="genre" value = '{{$book->Genre}}'>
                            </div>
                        </div>
                        <div class="row mb-3 px-2">
                            <label class="col-md-2 col-form-label" for="isbn">Synopsis:</label>
                            <div class="col-md-10">
                            <textarea rows="5" class="form-control" type="text" id="summary" name="summary">{{$book->Synopsis}}</textarea>
                            </div>
                        </div>
                        <input style='display:none;' name="id" value = '{{$book->ID}}'>
                        <div class="row mb-3">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>


      
</div>
<script>
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file)
        }
    }
</script>


@endsection