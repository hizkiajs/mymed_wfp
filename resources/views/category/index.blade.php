@extends('layouts.conquer2')
@section('content')
<div class="container">
  <div class="page-content">
    @if(session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
    @endif
  </div>
  <div class="page-bar">
    <ul class="page-breadcrumb">
      <li>
        <i class="fa fa-home"></i>
        <a href="index.html">Home</a>
        <i class="fa fa-angle-right"></i>
      </li>
      <li>
        <a href="index.html">Kategori</a>
      </li>
      <li>
        <a href="#modalCreate" data-toggle='modal' class="btn btn-info">+ Kategori Baru (Modal)</a>
      </li>
    </ul>
  </div>
  <div class="modal fade" id="modalCreate" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ url('kategori_obat') }}" method="POST">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Add New Category</h4>
          </div>
          <div class="modal-body">

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

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalEdit" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="modalContent">
      </div>
    </div>
  </div>
  <h2>List Medicines</h2>
  <p>The .table-hover class enables a hover state on table rows:</p>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nama Kategori</th>
        <th>Description</th>
        <th>Action1</th>
      </tr>
    </thead>
    <tbody>
      @foreach($listCategory as $li)
      <tr id="tr_{{ $li->id}}">
        <td id="td_name_{{ $li->id }}">{{$li->name}}</td>
        <td id="td_description_{{ $li->id }}">{{ $li->description }}</td>
        <td>
          <a href="{{ url('kategori_obat/'.$li->id.'/edit') }}" class="btn btn-xs btn-info">Edit</a>
          <form action="{{ url('kategori_obat/'.$li->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="submit" value="delete" class="btn btn-danger btn-xs" onclick="if(!confirm('are you sure to delete this record?')) return false;">
          </form>
        </td>
        <td>
          <a href="#modalEdit" data-toggle="modal" class="btn btn-warning btn-xs" onclick="getEditForm({{ $li->id }})">+ Edit A</a>
          <a href="#modalEdit" data-toggle="modal" class="btn btn-warning btn-xs" onclick="getEditForm2({{ $li->id }})">+ Edit B</a>
        </td>
        <td>
          <a href="#modalEdit" data-toggle="modal" class="btn btn-danger btn-xs" onclick="if(confirm('are you sure to delete this record?')) deleteDataRemoveTR({{ $li->id }})">Delete 2</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
@section('javascript')
<script>
  function getEditForm(id) {
    $.ajax({
      type: 'POST',
      url: '{{ route("kategori_obat.getEditForm") }}',
      data: {
        '_token': '<?php echo csrf_token() ?>',
        'id': id
      },
      success: function(data) {
        $('#modalContent').html(data.msg)
      }
    });
  }

  function getEditForm2(id) {
    $.ajax({
      type: 'POST',
      url: '{{ route("kategori_obat.getEditForm2") }}',
      data: {
        '_token': '<?php echo csrf_token() ?>',
        'id': id
      },
      success: function(data) {
        $('#modalContent').html(data.msg)
      }
    });
  }

  function deleteDataRemoveTR(id) {
    $.ajax({
      type: 'POST',
      url: '{{ route("kategori_obat.deleteData") }}',
      data: {
        '_token': '<?php echo csrf_token() ?>',
        'id': id
      },
      success: function(data) {
        if(data.status == "ok"){
          alert(data.msg)
          $('#tr_'+id).remove();
        }
        else{
          alert(data.msg);
        }
      }
    });
  }
</script>
@endsection