@extends('layout.admin')

@section('content')
    @push('style')
        <style type="text/css">
            .read-more-show {
                cursor: pointer;
                color: #3123ed;
            }

            .read-more-hide {
                cursor: pointer;
                color: #3123ed;
            }

            .hide_content {
                display: none;
            }
        </style>
    @endpush

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><b>Jadwal Agenda</b></h1>
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
        @foreach ($events as $event)
            <div class="col-md-4 mb-4" style="flex: 0 0 33.333333333333336%">
                <div class="card h-100">
                    <div class="card-img-container" style="position: relative; padding-top: 100%;">
                        <img src="{{ asset('storage/' . $event->thumbnail) }}"
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <small>
                            <h6 class="card-subtitle mb-2 text-muted">dilaksanakan tanggal : {{ $event->date }}</h6>
                        </small>
                        <div class="card-subtitle mb-2 text-muted">dibuat oleh : {{ $event->by->name }}</div>
                        <p class="card-text">
                            @if (strlen($event->description) > 50)
                                {{ substr($event->description, 0, 50) }}
                                <span class="read-more-show">More <i class="fa fa-angle-down"></i></span>
                                <span class="read-more-content">
                                    {{ substr($event->description, 50, strlen($event->description)) }}
                                    <span class="read-more-hide">Less <i class="fa fa-angle-up"></i></span>
                                </span>
                            @else
                                {{ $event->description }}
                            @endif
                        <p class="card-text"><small class="text-muted">{{ $event->created_at->diffForHumans() }}</small>
                        </p>
                        <div class="d-flex justify-content-between gap-2">
                            <div style="flex-grow: 1">
                                <button class="btn btn-warning w-100" data-toggle="modal" data-target="#formulir"
                                    onclick="editForm('{{ route('event.update', $event->id) }}', {{ $event }})"><i
                                        class="fas fa-edit"></i> edit</button>
                            </div>
                            <div style="flex-grow: 1; margin-left: 1rem;">
                                <button class="icon btn btn-danger text-white-50 w-100" type="button"
                                    onclick="if(confirm('Apakah anda yakin ingin menghapus data ini?')){document.getElementById('delete-{{ $event->id }}').submit()}"><i
                                        class="fas fa-trash"></i> delete</button>
                            </div>
                            <form action="{{ route('event.destroy', $event->id) }}" method="POST"
                                id="delete-{{ $event->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @component('components.modal', ['target' => 'formulir', 'title' => 'lengkapi data informasi berikut'])
        <form action="" method="POST" enctype="multipart/form-data" id="form-event">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <input type="hidden" name="author" value="{{ auth()->user()->id }}">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="date">tampil sampai tanggal</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="thumbnail">thumbnail</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                </div>
                <div class="form-group">
                    <label for="description">deskripsi kegiatan</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="status">status</label>
                    <select id="status" class="form-control" name="status" required>
                        <option selected>Choose...</option>
                        <option value="1">tampilkan kegiatan</option>
                        <option value="0">sembuyikan kegiatan</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
            </div>
        </form>
    @endcomponent
    @push('script')
        <script>
            $(document).ready(function() {
                $('.read-more-content').addClass('hide_content')
                $('.read-more-show, .read-more-hide').removeClass('hide_content')

                // Set up the toggle effect:
                $('.read-more-show').on('click', function(e) {
                    $(this).next('.read-more-content').removeClass('hide_content');
                    $(this).addClass('hide_content');
                    e.preventDefault();
                });
                $('.read-more-hide').on('click', function(e) {
                    var p = $(this).parent('.read-more-content');
                    p.addClass('hide_content');
                    p.prev('.read-more-show').removeClass(
                        'hide_content'); // Hide only the preceding "Read More"
                    e.preventDefault();
                });
            });

            function clearForm() {
                document.getElementById('title').value = '';
                document.getElementById('date').value = '';
                document.getElementById('description').value = '';
                document.getElementById('status').value = '';
                document.getElementById('form-event').action = "{{ route('event.store') }}";
                document.getElementById('form-event').querySelector('input[name="_method"]').value = 'POST';
                document.getElementById('submitButton').classList.remove('btn-warning');
                document.getElementById('submitButton').classList.add('btn-primary');
                document.getElementById('submitButton').textContent = 'Submit';
            }

            function editForm(url, event) {
                document.getElementById('title').value = event.title;
                document.getElementById('date').value = event.date;
                document.getElementById('description').value = event.description;
                document.getElementById('status').value = event.status;
                document.getElementById('form-event').action = url;
                document.getElementById('form-event').querySelector('input[name="_method"]').value = 'PUT';
                document.getElementById('submitButton').classList.remove('btn-primary');
                document.getElementById('submitButton').classList.add('btn-warning');
                document.getElementById('submitButton').textContent = 'Update';
            }
        </script>
    @endpush
@endsection
