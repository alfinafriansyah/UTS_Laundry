@extends('admin.layouts.template')

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
                        
                        <div class="row">
                            <div class="col">
                                <button onclick="modalAction('{{ url('admin/pelanggan/create') }}')" class="btn btn-primary float-end mb-3">Tambah</button>
                            </div>
                        </div>

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
                                            @foreach ($nama as $nama_pelanggan)
                                                <option value="{{ $nama_pelanggan }}">{{ ucfirst($nama_pelanggan) }}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Nama Pelanggan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table_pelanggan">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>No Telepon</th>
                                        <th>Alamat</th>
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
var dataPelanggan;
function modalAction(url = '') {
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}
$(document).ready(function() {
    dataPelanggan = $('#table_pelanggan').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('admin/pelanggan/list') }}",
            dataType: "json",
            type: "POST",
            "data": function(d) {
                d.nama_pelanggan = $('#nama_pelanggan').val();
            }
        },
        columns: [
            {
                data: "DT_RowIndex",
                className: "text-center",
                orderable: false,
                searchable: false
            },
            {
                data: "nama_pelanggan",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "telp",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "alamat",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "aksi",
                className: "",
                orderable: false,
                searchable: false
            }
        ]
    });

    $('#nama_pelanggan').on('change', function() {
        dataPelanggan.ajax.reload();
    });
});
</script>
@endpush