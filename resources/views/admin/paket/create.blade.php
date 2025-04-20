<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Paket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('admin/paket/store') }}" method="POST" id="form-tambah">
                @csrf
                <div class="mb-3">
                    <label>Kode Paket</label>
                    <input type="text" class="form-control" name="kode_paket" id="kode_paket" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label>Nama Paket</label>
                    <input type="text" class="form-control" name="nama_paket" id="nama_paket" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label>Jenis</label>
                    <select name="jenis" id="jenis" class="form-select" required>
                        <option value="">Pilih Jenis</option>
                        <option value="kiloan">Kiloan</option>
                        <option value="selimut">Selimut</option>
                        <option value="bedcover">Bed Cover</option>
                    </select>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="text" class="form-control" name="harga" id="harga" autocomplete="off" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                kode_paket: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                nama_paket: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                jenis: {
                    required: true
                },
                harga: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                    number: true
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