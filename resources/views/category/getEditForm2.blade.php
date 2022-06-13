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
                <input type="text" class="form-control" id="eName" placeholder="Nama Kategori" name="name" value="{{ $data->name }}">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" id="eDescription" placeholder="Deskripsi" name="description" value="{{ $data->description }}">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal" onclick="saveDataUpdateID({{ $data->id }})">Submit</button>
    </div>
</form>
<script>
    function saveDataUpdateID(id){
        var eName = $('#eName').val();
        var eDescription = $('#eDescription').val();
        $.ajax({
            type:'POST',
            url:'{{ route("kategori_obat.saveData") }}',
            data:{'_token':'<?php echo csrf_token() ?>', 'id':id, 'name':eName, 'description':eDescription},
            success: function(data){
                if(data.status == 'ok'){
                    alert(data.msg)
                    $('#td_name_'+id).html(eName);
                    $('#td_description_'+id).html(eDescription);
                }
            }
        });
    }
</script>