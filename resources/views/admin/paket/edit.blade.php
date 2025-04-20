@empty($paket)
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
            <a href="{{ url('/admin/paket') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Paket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('/admin/paket/' . $paket->id_paket . '/update') }}" method="POST" id="form-edit">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Kode Paket</label>
                    <input value="{{ $paket->kode_paket }}" type="text" class="form-control" name="kode_paket" id="kode_paket" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label>Nama Paket</label>
                    <input value="{{ $paket->nama_paket }}" type="text" class="form-control" name="nama_paket" id="nama_paket" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label>Jenis</label>
                    <select name="jenis" id="jenis" class="form-select" required>
                        <option value="">Pilih Jenis</option>
                        <option value="kiloan" {{ $paket->jenis == 'kiloan' ? 'selected' : '' }}>Kiloan</option>
                        <option value="selimut" {{ $paket->jenis == 'selimut' ? 'selected' : '' }}>Selimut</option>
                        <option value="bedcover" {{ $paket->jenis == 'bedcover' ? 'selected' : '' }}>Bed Cover</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input value="{{ $paket->harga }}" type="text" class="form-control" name="harga" id="harga" autocomplete="off" required>
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
                nama_paket: {
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