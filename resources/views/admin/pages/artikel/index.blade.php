@extends('admin.master')

@section('css-plus')
    <style>
        table td {
            word-wrap: break-word;
            /* Untuk browser lama */
            /* word-break: break-word; */
            /* Untuk browser modern */
            white-space: normal;
            /* Mengizinkan teks untuk membungkus */
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h3>Manajemen Artikel</h3>

            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">Daftar Artikel</h5>
                    <div class="#">
                        <button class="btn btn-primary me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#addNews"
                            aria-controls="addNews">
                            + Tambah Artikel
                        </button>
                        <div class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="addNews"
                            aria-labelledby="offcanvasBackdropLabel">
                            <div class="offcanvas-header border-bottom">
                                <h5 id="offcanvasBackdropLabel" class="offcanvas-title">Tambah Artikel</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0">
                                <form action="{{ route('admin.artikel.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="file" class="form-control" name="cover" id="cover"
                                            placeholder="Gambar Artikel" />
                                        <label for="cover">Gambar Artikel</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="text" class="form-control" name="judul" id="judul"
                                            placeholder="Judul Artikel" />
                                        <label for="judul">Judul Artikel</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <textarea id="isi" class="form-control" name="isi" placeholder="Deskripsi Artikel" style="height: 100px"></textarea>
                                        <label for="isi">Deskripsi Artikel</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                                    <button type="button" class="btn btn-outline-secondary mb-2"
                                        data-bs-dismiss="offcanvas">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    {{-- Alerts --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- / Alerts --}}
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="25%">Gambar</th>
                                <th>Judul</th>
                                <th>Isi</th>
                                <th>Status</th>
                                <th width="10%">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($articles as $data)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $data->cover) }}" alt="{{ ucwords($data->judul) }}"
                                            class="rounded" style="width: 100%;" />
                                    </td>
                                    <td>{{ ucwords($data->judul) }}</td>
                                    <td>
                                        {{ Str::limit($data->isi, 100, '...') }}
                                    </td>
                                    <td>
                                        @if ($data->is_active)
                                            <span class="badge rounded-pill bg-label-primary me-1">Active</span>
                                        @else
                                            <span class="badge rounded-pill bg-label-secondary me-1">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none"
                                                data-bs-toggle="dropdown">
                                                <i class="icon-base ri ri-more-2-line icon-18px"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item" data-bs-toggle="offcanvas"
                                                    data-bs-target="#editArticle-{{ $data->slug }}">
                                                    <i class="ri ri-pencil-line me-1"></i> Edit
                                                </button>
                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal-{{ $data->slug }}">
                                                    <i class="ri ri-eye-line me-1"></i> View
                                                </button>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.artikel.destroy', $data->slug) }}"
                                                    data-confirm-delete="true">
                                                    <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                                    Delete
                                                </a>
                                            </div>
                                            <div class="offcanvas offcanvas-end w-50" tabindex="-1"
                                                id="editArticle-{{ $data->slug }}">
                                                <div class="offcanvas-header border-bottom">
                                                    <h5>Edit Artikel</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="offcanvas"></button>
                                                </div>

                                                <div class="offcanvas-body">
                                                    <form action="{{ route('admin.artikel.update', $data->slug) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        {{-- Preview gambar lama --}}
                                                        <div class="mb-4">
                                                            <label class="form-label">Gambar Saat Ini</label>
                                                            <img src="{{ asset('storage/' . $data->cover) }}"
                                                                class="img-fluid rounded">
                                                        </div>

                                                        <div class="form-floating mb-4">
                                                            <input type="file" class="form-control" name="cover">
                                                            <label>Ganti Gambar (Opsional)</label>
                                                        </div>

                                                        <div class="form-floating mb-4">
                                                            <input type="text" class="form-control" name="judul"
                                                                value="{{ $data->judul }}" required>
                                                            <label>Judul Artikel</label>
                                                        </div>

                                                        <div class="form-floating mb-4">
                                                            <textarea class="form-control" name="isi" style="height: 120px" required>{{ $data->isi }}</textarea>
                                                            <label>Isi Artikel</label>
                                                        </div>

                                                        <button class="btn btn-primary">Edit</button>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="offcanvas">Batal</button>
                                                    </form>
                                                </div>
                                            </div>

                                            {{-- Modal View Artikel --}}
                                            <div class="modal fade" id="viewModal-{{ $data->slug }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Detail Artikel</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <img src="{{ asset('storage/' . $data->cover) }}"
                                                                class="img-fluid rounded mb-3">

                                                            <h4>{{ $data->judul }}</h4>

                                                            <p class="text-muted">
                                                                Status:
                                                                <span
                                                                    class="badge {{ $data->is_active ? 'bg-primary' : 'bg-secondary' }}">
                                                                    {{ $data->is_active ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </p>

                                                            <hr>

                                                            <p style="white-space: pre-line;">
                                                                {{ $data->isi }}
                                                            </p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Modal View Artikel --}}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada berita yang tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($articles->isEmpty())
                        {{ null }}
                    @else
                        <div style="padding: 2rem 0 0 1rem">
                            {{ $articles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- / Content -->
    </div>
@endsection
