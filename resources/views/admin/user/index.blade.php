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
                                <button onclick="modalAction('{{ url('admin/user/create') }}')" class="btn btn-primary float-end mb-3">Tambah</button>
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
                                        <select name="role" id="role" class="form-select" required>
                                            <option value="">- Semua -</option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                            @endforeach
                                        </select>
                                        <small class="form-text text-muted">Role Pengguna</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="table_user">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Role</th>
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
var dataUser;
function modalAction(url = '') {
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}
$(document).ready(function() {
    dataUser = $('#table_user').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('admin/user/list') }}",
            dataType: "json",
            type: "POST",
            "data": function(d) {
                d.role = $('#role').val();
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
                data: "nama_user",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "username",
                className: "",
                orderable: true,
                searchable: true
            },
            {
                data: "role",
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

    $('#role').on('change', function() {
        dataUser.ajax.reload();
    });
});
</script>
@endpush