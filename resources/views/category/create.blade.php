@extends('layouts.conquer2')
@section('content')
<form action="{{ url('kategori_obat/'.$data->id) }}" method="POST">
    @csrf
    @method("PUT")
    <div class="form-group">
        <label for="name">Nama:</label>
        <input type="text" class="form-control" id="name" placeholder="Nama Kategori" name="name">
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <input type="text" class="form-control" id="description" placeholder="Deskripsi" name="description">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection