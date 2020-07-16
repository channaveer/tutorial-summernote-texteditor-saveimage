@extends('layouts.master')
@section('stylesheets')
    <!-- SummerNote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection
@section('javascripts')
    <!-- jQuery JS Library -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <!-- SummerNote Javascript Library -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function () {
            /** Initialize SummerNote Javscript For Textarea */
            $('#message').summernote({
                height: '300px'
            });
        });
    </script>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h2 class="text-primary">WYSIWYG Editor</h2>
            <form action="{{ url('file-uploads') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="message">Message Body</label>
                        @error('message')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <textarea rows="10" name="message" id="message" class="form-control"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <input type="submit" value="Upload File" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
