@extends('layout.admin')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>Daftar anggota</b></h1>
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
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Nomor</th>
                                <th>tanggal lahir</th>
                                <th>periode</th>
                                <th>divisi</th>
                                <th>prodi</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Nomer Hp</th>
                                <th>tanggal lahir</th>
                                <th>periode</th>
                                <th>divisi</th>
                                <th>prodi</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ $member->NIM }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->number_hp }}</td>
                                    <td>{{ $member->birth_date }}</td>
                                    <td>{{ $member->period }}</td>
                                    <td>{{ $member->division ? $member->division->name : '' }}</td>
                                    <td>{{ $member->prodi ? $member->prodi->name : '' }}</td>
                                    <td class="text-center">
                                        <span class="icon btn btn-warning text-white-50" data-toggle="modal"
                                            data-target="#formulir"
                                            onclick="editForm('{{ route('member.update', $member->id) }}', {{ $member }})"><i
                                                class="fas fa-edit"></i></span>
                                        <span class="icon btn btn-danger text-white-50" type="button"
                                            onclick="if(confirm('Apakah anda yakin ingin menghapus data ini?')){document.getElementById('delete-{{ $member->id }}').submit()}"><i
                                                class="fas fa-trash"></i>
                                        </span>
                                        <form action="{{ route('member.destroy', $member->id) }}" method="post"
                                            id="delete-{{ $member->id }}">
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
        <form action="" method="post" id="form-member">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="NIM">NIM</label>
                        <input type="text" class="form-control" id="NIM" name="NIM" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="number_hp">nomer Hp</label>
                        <input type="text" class="form-control" id="number_hp" name="number_hp" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="birth_date">tanggal lahir</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="period">periode</label>
                        <input type="text" class="form-control" id="period" name="period" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="division">divisi</label>
                        <select id="division" class="form-control" name="division_id" required>
                            <option selected>Choose...</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="prodi">prodi</label>
                        <select id="prodi" class="form-control" name="prodi_id" required>
                            <option selected>Choose...</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button id="submitButton" class="btn btn-primary" type="submit">Submit</button>
            </div>
        </form>
    @endcomponent
    @push('script')
        <script>
            function clearForm() {
                document.getElementById('name').value = '';
                document.getElementById('NIM').value = '';
                document.getElementById('number_hp').value = '';
                document.getElementById('birth_date').value = '';
                document.getElementById('period').value = '';
                document.getElementById('division').value = '';
                document.getElementById('prodi').value = '';
                document.getElementById('form-member').action = "{{ route('member.store') }}";
                document.getElementById('form-member').querySelector('input[name="_method"]').value = 'POST';
                document.getElementById('submitButton').classList.remove('btn-warning');
                document.getElementById('submitButton').classList.add('btn-primary');
                document.getElementById('submitButton').textContent = 'Submit';
            }

            function editForm(url, member) {
                document.getElementById('name').value = member.name;
                document.getElementById('NIM').value = member.NIM;
                document.getElementById('number_hp').value = member.number_hp;
                document.getElementById('birth_date').value = member.birth_date;
                document.getElementById('period').value = member.period;
                document.getElementById('division').value = member.division_id;
                document.getElementById('prodi').value = member.prodi_id;
                document.getElementById('form-member').action = url;
                document.getElementById('form-member').querySelector('input[name="_method"]').value = 'PUT';
                document.getElementById('submitButton').classList.remove('btn-primary');
                document.getElementById('submitButton').classList.add('btn-warning');
                document.getElementById('submitButton').textContent = 'Update';
            }
        </script>
    @endpush
@endsection
