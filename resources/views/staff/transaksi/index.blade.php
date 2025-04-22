@extends('staff.layouts.template')

@section('content')
    <div class="pagetitle">
        <h1>{{ $page->title }}</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">

                <div class="card">
                
                    <div class="card-body">
                
                        <h5 class="card-title">{{ $page->card }}</h5>
                        <form method="POST" action="{{ url('staff/transaksi/store') }}" id="form-transaksi">
                            @csrf
                            <div class="mb-3">
                                <label>Kode Transaksi</label>
                                <input type="text" value="{{ $kode }}" class="form-control" name="kode_trans" id="kode_trans" readonly required>
                            </div>
                            <div class="mb-3">
                                <label>Pelanggan</label>
                                <select class="form-select" name="id_pelanggan" id="id_pelanggan" data-placeholder="Cari Pelanggan" required>                            
                                    <option value=""></option>
                                    @foreach ($pelanggan as $row)
                                        <option value="{{ $row->id_pelanggan }}">{{ $row->nama_pelanggan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Tanggal Transaksi</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="tanggal" id="tanggal" autocomplete="off" readonly required>
                            </div>
                            <div class="mb-3">
                                <label>Estimasi Selesai</label>
                                <input type="date" value="{{ date('Y-m-d') }}" class="form-control" name="batas_waktu" id="batas_waktu" autocomplete="off" required>
                            </div>
                            <div class="mb-3">
                                <label>Paket</label>
                                <select class="form-select" name="id_paket" id="id_paket" onchange='changeValue(this.value)' data-placeholder="Cari Paket" required>                            
                                    <option value=""></option>
                                    <script>
                                        var harga = {};
                                    </script>
                                    @foreach ($paket as $row)
                                        <option value="{{ $row->id_paket }}">{{ $row->nama_paket }}</option>
                                        <script>                                            
                                            harga['{{ $row->id_paket }}'] = {{ $row->harga }};
                                        </script>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Quantity</label>
                                <input type="text" id="quantity" name="quantity" class="form-control quantity" required>
                            </div>
                            <div class="mb-3">
                                <label>Harga</label>
                                <input readonly type="text" id="harga_satuan" name="harga_satuan" class="form-control harga_satuan" required>
                            </div>
                            <div class="mb-3">
                                <label>Subtotal</label>
                                <input readonly type="text" id="subtotal" name="subtotal" class="form-control subtotal" required>
                                <input readonly type="hidden" id="status" name="status" class="form-control" value="baru" required>
                                <input readonly type="hidden" id="pembayaran" name="pembayaran" class="form-control" value="belum" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data- backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
                    
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
@endpush

@push('js')
<script>
    $('#id_pelanggan').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });
    $('#id_paket').select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    });

    // Fungsi untuk mengubah nilai harga dan subtotal
    function changeValue(id_paket) {
        const quantity = document.getElementById("quantity").value || 0;
        document.getElementById("harga_satuan").value = harga[id_paket] || 0;
        document.getElementById("subtotal").value = (harga[id_paket] || 0) * quantity;
    }

    // Event listener untuk menghitung subtotal saat quantity berubah
    document.getElementById("quantity").addEventListener("input", function () {
        const id_paket = document.getElementById("id_paket").value;
        const quantity = this.value || 0;
        document.getElementById("subtotal").value = (harga[id_paket] || 0) * quantity;
    });

    $(document).ready(function() {
        $("#form-transaksi").validate({
            rules: {
                kode_trans: {
                    required: true
                },
                id_pelanggan: {
                    required: true
                },
                tanggal: {
                    required: true
                },
                batas_waktu: {
                    required: true
                },
                status: {
                    required: true
                },
                pembayaran: {
                    required: true
                },
                id_paket: {
                    required: true
                },
                quantity: {
                    required: true,
                    number: true,
                    min: 1
                },
                harga_satuan: {
                    required: true,
                    number: true
                },
                subtotal: {
                    required: true,
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
                            window.location.href = "{{ url('staff/history') }}";
                            Swal.fire('Sukses', response.message, 'success');
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
@endpush