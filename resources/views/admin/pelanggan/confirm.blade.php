@empty($pelanggan)
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="bi bi-x-circle"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/admin/pelanggan') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="bi bi-x-circle"></i> Konfirmasi !!!</h5>
                Apakah Anda ingin menghapus data bawah ini?
            </div>
            <form action="{{ url('/admin/pelanggan/' . $pelanggan->id_pelanggan . '/delete') }}" method="POST" id="form-delete">
                @csrf
                @method('DELETE')
                <div class="row mb-3">
                    <div class="col-sm-4">Nama Pelanggan</div>
                    <div class="col-sm-1"> : </div>
                    <div class="col-sm-7">{{ $pelanggan->nama_pelanggan }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">No Telepon</div>
                    <div class="col-sm-1"> : </div>
                    <div class="col-sm-7">{{ $pelanggan->telp }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">Alamat</div>
                    <div class="col-sm-1"> : </div>
                    <div class="col-sm-7">{{ $pelanggan->alamat }}</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form-delete").validate({
            rules: {},
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire('Sukses', response.message, 'success');
                            dataPelanggan.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Reset error sebelumnya
                            $('.is-invalid').removeClass('is-invalid');
                            $('.text-danger').remove();
                            
                            // Tampilkan error validasi
                            const errors = xhr.responseJSON.errors;
                            for (const field in errors) {
                                const input = $(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                input.after(`<small class="text-danger error-${field}">${errors[field][0]}</small>`);
                            }
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan server', 'error');
                        }
                    }
                });
                return false;
            },
            errorElement: 'small',
            errorClass: 'text-danger',
            errorPlacement: function(error, element) {
                // Tempatkan error message setelah input
                error.insertAfter(element);
            },
            highlight: function(element, errorClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass) {
                $(element).removeClass('is-invalid');
            },
        });
    });
</script>
@endempty