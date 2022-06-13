@extends('layouts.conquer2')
@section('content')
<form action="{{ route('kategori_obat.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Nama:</label>
        <input type="text" class="form-control" id="name" placeholder="Nama Kategori" name="name" value="{{ $data->name }}">
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" class="form-control" id="description" placeholder="Deskripsi" name="description" value="{{ $data->description }}">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection