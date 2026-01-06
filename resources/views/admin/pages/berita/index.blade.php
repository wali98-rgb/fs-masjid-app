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
            <h3>Manajemen Berita</h3>

            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">Daftar Berita</h5>
                    <div class="#">
                        <button class="btn btn-primary me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#addNews"
                            aria-controls="addNews">
                            + Tambah Berita
                        </button>
                        <div class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="addNews"
                            aria-labelledby="offcanvasBackdropLabel">
                            <div class="offcanvas-header border-bottom">
                                <h5 id="offcanvasBackdropLabel" class="offcanvas-title">Tambah Berita</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0">
                                <form action="{{ route('admin.berita.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="file" class="form-control" name="cover" id="cover"
                                            placeholder="Gambar Berita" />
                                        <label for="cover">Gambar Berita</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="text" class="form-control" name="judul" id="judul"
                                            placeholder="Judul Berita" />
                                        <label for="judul">Judul Berita</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <textarea id="isi" class="form-control" name="isi" placeholder="Deskripsi Berita" style="height: 100px"></textarea>
                                        <label for="isi">Deskripsi Berita</label>
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
                            @forelse ($berita as $data)
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
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                                                    Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0);">
                                                    <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                                    Delete</a>
                                            </div>
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
                </div>
            </div>
        </div>
        <!-- / Content -->
    </div>
@endsection
