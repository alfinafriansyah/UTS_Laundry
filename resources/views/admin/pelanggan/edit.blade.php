@empty($pelanggan)
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="bi bi-ban"></i> Kesalahan!!!</h5>
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
            <h5 class="modal-title" id="exampleModalLabel">Edit Pelanggan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/admin/pelanggan/' . $pelanggan->id_pelanggan . '/update') }}" method="POST" id="form-edit">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Nama Pelanggan</label>
                    <input value="{{ $pelanggan->nama_pelanggan }}" type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label>No Telepon</label>
                    <input value="{{ $pelanggan->telp }}" type="text" class="form-control" name="telp" id="telp" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <input value="{{ $pelanggan->alamat }}" type="text" class="form-control" name="alamat" id="alamat" autocomplete="off" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form-edit").validate({
            rules: {
                nama_pelanggan: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                telp: {
                    required: true,
                    minlength: 11,
                    maxlength: 15,
                    number: true
                },
                alamat: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                }
            },
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