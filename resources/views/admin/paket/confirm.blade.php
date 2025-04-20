@empty($paket)
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
            <a href="{{ url('/admin/paket') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus Paket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="bi bi-x-circle"></i> Konfirmasi !!!</h5>
                Apakah Anda ingin menghapus data bawah ini?
            </div>
            <form action="{{ url('/admin/paket/' . $paket->id_paket . '/delete') }}" method="POST" id="form-delete">
                @csrf
                @method('DELETE')
                <div class="row mb-3">
                    <div class="col-sm-4">Kode Paket</div>
                    <div class="col-sm-1"> : </div>
                    <div class="col-sm-7">{{ $paket->kode_paket }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">Nama Paket</div>
                    <div class="col-sm-1"> : </div>
                    <div class="col-sm-7">{{ $paket->nama_paket }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">Jenis Paket</div>
                    <div class="col-sm-1"> : </div>
                    <div class="col-sm-7">{{ $paket->jenis }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4">Harga</div>
                    <div class="col-sm-1"> : </div>
                    <div class="col-sm-7">{{ $paket->harga }}</div>
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
                            dataPaket.ajax.reload();
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