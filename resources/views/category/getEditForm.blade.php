<form action="{{ url('kategori_obat/'.$data->id) }}" method="POST">
    <div class="model-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
        <h4 class="modal-title">Edit Kategori</h4>
    </div>
    <div class="modal-body">
        @csrf
        @method('PUT')
        <div class="form-body">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" class="form-control" id="name" placeholder="Nama Kategori" name="name" value="{{ $data->name }}">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description" placeholder="Deskripsi" name="description" value="{{ $data->description }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>