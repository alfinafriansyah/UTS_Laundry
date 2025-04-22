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

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-1 control-label col-form-label">Filter:</label>
                                    <div class="col-3">
                                        <select name="nama_pelanggan" id="nama_pelanggan" class="form-select" required>
                                            <option value="">- Semua -</option>
                                            @foreach ($pelanggan as $pelanggan)
                                                <option value="{{ $pelanggan }}">{{ ucfirst($pelanggan) }}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Nama Pelanggan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table_history">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Kode Transaksi</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Paket</th>
                                        <th>Quantity</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Estimasi Selesai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
var dataHistory;
function modalAction(url = '') {
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}
$(document).ready(function() {
    dataHistory = $('#table_history').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('staff/history/list') }}",
            dataType: "json",
            type: "POST",
            "data": function(d) {
                d.nama_pelanggan = $('#nama_pelanggan').val();
            },
            error: function(xhr, error, thrown) {
                console.log(xhr.responseText);
                alert('Terjadi kesalahan saat memuat data');
            }
        },
        
        columns: [
            { 
                data: 'DT_RowIndex',
                orderable: false, 
                searchable: false 
            },
            { 
                data: 'kode_trans', 
                orderable: true, 
                searchable: true 
            },
            { 
                data: 'nama_pelanggan', 
                orderable: true, 
                searchable: true 
            },
            { 
                data: 'nama_paket', 
                orderable: true, 
                searchable: true 
            },
            { 
                data: 'quantity', 
                orderable: true, 
                searchable: true 
            },
            { 
                data: 'harga_satuan', 
                orderable: true, 
                searchable: true,
                render: $.fn.dataTable.render.number('.', ',', 2, 'Rp ')
            },
            { 
                data: 'subtotal', 
                orderable: true, 
                searchable: true,
                render: $.fn.dataTable.render.number('.', ',', 2, 'Rp ')
            },
            { 
                data: 'tanggal', 
                orderable: true, 
                searchable: true 
            },
            { 
                data: 'batas_waktu', 
                orderable: true, 
                searchable: true 
            },
            { 
                data: 'status', 
                orderable: true, 
                searchable: true 
            },
            { 
                data: 'aksi', 
                orderable: false, 
                searchable: false 
            }
        ]
    });

    $('#nama_pelanggan').on('change', function() {
        dataHistory.ajax.reload();
    });
});

// Handle tombol proses
$(document).on('click', '.btn-proses', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Konfirmasi Proses',
        text: "Apakah Anda yakin ingin memproses transaksi ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Proses!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            updateStatus(id, 'diproses');
        }
    });
});

// Handle tombol selesai
$(document).on('click', '.btn-selesai', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Konfirmasi Selesai',
        text: "Apakah Anda yakin menyelesaikan transaksi ini?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Selesai!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            updateStatus(id, 'selesai');
        }
    });
});

// Handle tombol hapus
$(document).on('click', '.btn-hapus', function() {
    const id = $(this).data('id');
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: "Data transaksi akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteTransaction(id);
        }
    });
});

// Fungsi update status dengan notifikasi sukses/gagal
function updateStatus(id, status) {
    $.ajax({
        url: "{{ url('staff/history/update-status') }}",
        type: "POST",
        data: {
            id_trans: id,
            status: status,
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if(response.success) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    dataHistory.ajax.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan: ' + xhr.responseText,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}

// Fungsi hapus transaksi dengan notifikasi
function deleteTransaction(id) {
    $.ajax({
        url: "{{ url('staff/history/delete') }}/" + id,
        type: "DELETE",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function(response) {
            if(response.success) {
                Swal.fire({
                    title: 'Terhapus!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    dataHistory.ajax.reload();
                });
            } else {
                Swal.fire({
                    title: 'Gagal!',
                    text: response.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr) {
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan: ' + xhr.responseText,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
}
</script>
@endpush