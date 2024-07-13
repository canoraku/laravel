@extends('layout.admin')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>Data Pendaftar</b></h1>
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
                                <th>Nomer Hp</th>
                                <th>tanggal lahir</th>
                                <th>lembar motivasi</th>
                                <th>resume</th>
                                <th>prodi</th>
                                <th>status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Nomer Hp</th>
                                <th>tanggal lahir</th>
                                <th>lembar motivasi</th>
                                <th>resume</th>
                                <th>prodi</th>
                                <th>status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($registrants as $registrant)
                                <tr>
                                    <td>{{ $registrant->NIM }}</td>
                                    <td>{{ $registrant->name }}</td>
                                    <td>{{ $registrant->number_hp }}</td>
                                    <td>{{ $registrant->birth_date }}</td>
                                    <td><a href="{{ asset('storage/' . $registrant->motivation_later) }}"
                                            target="_blank">cek</a>
                                    </td>
                                    <td><a href="{{ asset('storage/' . $registrant->CV) }}" target="_blank">cek</a></td>
                                    <td>{{ $registrant->prodi ? $registrant->prodi->name : '' }}</td>
                                    <td>
                                        @if ($registrant->is_accepted === 0)
                                            <span class="icon btn btn-secondary text-white-50" title="Proses" type="button"
                                                disabled><i class="fas fa-cog"> proses</i></span>
                                        @elseif ($registrant->is_accepted === 1)
                                            <span class="icon btn btn-success text-white-50" title="Diterima" type="button"
                                                disabled><i class="fas fa-check"></i> diterima</span>
                                        @elseif ($registrant->is_accepted === 2)
                                            <span class="icon btn btn-danger text-white-50" title="Ditolak" type="button"
                                                disabled><i class="fas fa-times"></i> ditolak</span>
                                        @else
                                            <span class="icon btn btn-secondary text-white-50" title="Proses" type="button"
                                                disabled><i class="fas fa-cog"> invalid</i></span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="icon btn btn-success text-white-50"
                                            onclick="if(confirm('Cek data pendaftar terlebih dahulu, Apakah anda yakin akan menerimanya?')){document.getElementById('terima-{{ $registrant->id }}').submit()}"><i
                                                class="fas fa-check-circle"></i> Terima</span>
                                        <span class="icon btn btn-danger text-white-50" type="button"
                                            onclick="if(confirm('Cek data pendaftar terlebih dahulu, Apakah anda yakin akan menolaknya?')){document.getElementById('tolak-{{ $registrant->id }}').submit()}"><i
                                                class="fas fa-times-circle"></i> Tolak</span>
                                        <form action="{{ route('registrant.update', $registrant->id) }}" method="post"
                                            id="terima-{{ $registrant->id }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_accepted" value="1">
                                        </form>
                                        <form action="{{ route('registrant.update', $registrant->id) }}" method="post"
                                            id="tolak-{{ $registrant->id }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="is_accepted" value="2">
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
        <form action="{{ route('registrant.store') }}" method="post" id="form-registrant" enctype="multipart/form-data">
            @csrf
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
                    <div class="form-group col-md-4">
                        <label for="number_hp">nomer Hp</label>
                        <input type="text" class="form-control" id="number_hp" name="number_hp" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="birth_date">tanggal lahir</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                    </div>
                    <div class="form-group col-md-5">
                        <label for="prodi">prodi</label>
                        <select id="prodi" class="form-control" name="prodi_id" required>
                            <option selected>Choose...</option>
                            @foreach ($prodis as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="CV">upload CV</label>
                    <input type="file" class="form-control" id="CV" name="CV" required>
                </div>
                <div class="form-group">
                    <label for="motivation">upload lembar motivasi</label>
                    <input type="file" class="form-control" id="motivation" name="motivation_later" required>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
            </div>
        </form>
    @endcomponent
    @push('script')
    @endpush
@endsection
