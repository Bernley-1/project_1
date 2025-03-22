@extends('layouts.app')

@section('content')
<div class="container">
    <h1>File Manager</h1>
    <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Upload File</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
    <form action="{{ route('files.search') }}" method="GET" class="mt-3">
        <div class="form-group">
            <label for="query">Search Files</label>
            <input type="text" name="query" class="form-control" placeholder="Search...">
        </div>
        <button type="submit" class="btn btn-secondary">Search</button>
    </form>
    <ul class="list-group mt-3">
        @foreach($files as $file)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $file->name }}
                <form action="{{ route('files.destroy', $file->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
