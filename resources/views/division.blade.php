@extends('layout.admin')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>Daftar Divisi</b></h1>
        <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#formulir"
            onclick="clearForm()"><i class="fas fa-plus-circle fa-md"></i> Tambah data</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('update'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('update') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('delete') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Content Row -->
    <div class="row">
        <div class="card shadow" style="width: 100%">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Divisi</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Divisi</th>
                                <th>Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($divisions as $division)
                                <tr>
                                    <td>{{ $division->name }}</td>
                                    <td>{{ $division->description }}</td>
                                    <td class="text-center">
                                        <span class="icon btn btn-warning text-white-50" data-toggle="modal"
                                            data-target="#formulir"
                                            onclick="editForm('{{ route('division.update', $division->id) }}', {{ $division }})"><i
                                                class="fas fa-edit"></i></span>
                                        <span class="icon btn btn-danger text-white-50" type="button"
                                            onclick="if(confirm('Apakah anda yakin ingin menghapus data ini?')){document.getElementById('delete-{{ $division->id }}').submit()}"><i
                                                class="fas fa-trash"></i>
                                        </span>
                                        <form action="{{ route('division.destroy', $division->id) }}" method="post"
                                            id="delete-{{ $division->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @component('components.modal', ['target' => 'formulir', 'title' => 'lengkapi data informasi berikut'])
        <form action="" method="post" id="form-division">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama">nama divisi</label>
                        <input type="text" class="form-control" id="nama" name="name" placeholder="nama divisi"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="deskripsi">deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="description" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="submitButton" class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    @endcomponent

    <script>
        function clearForm() {
            document.getElementById('nama').value = '';
            document.getElementById('deskripsi').value = '';
            document.getElementById('form-division').action = "{{ route('division.store') }}";
            document.getElementById('form-division').querySelector('input[name="_method"]').value = 'POST';
            document.getElementById('submitButton').classList.remove('btn-warning');
            document.getElementById('submitButton').classList.add('btn-primary');
            document.getElementById('submitButton').textContent = 'Submit';
        }

        function editForm(url, division) {
            document.getElementById('nama').value = division.name;
            document.getElementById('deskripsi').value = division.description;
            document.getElementById('form-division').action = url;
            document.getElementById('form-division').querySelector('input[name="_method"]').value = 'PUT';
            document.getElementById('submitButton').classList.remove('btn-primary');
            document.getElementById('submitButton').classList.add('btn-warning');
            document.getElementById('submitButton').textContent = 'Update';
        }
    </script>
@endsection
