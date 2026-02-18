@extends('admin.master')

@section('css-plus')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <style>
        table th,
        td {
            word-wrap: break-word;
            /* Untuk browser lama */
            /* word-break: break-word; */
            /* Untuk browser modern */
            white-space: normal;
            /* Mengizinkan teks untuk membungkus */
        }

        .swiper {
            width: 100%;
            padding: 10px 0;
        }

        .swiper-slide {
            width: auto;
        }

        .gallery-thumb {
            width: 180px;
            height: 120px;
            object-fit: cover;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <h3>Manajemen Kegiatan</h3>

            <div class="card">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-header">Daftar Kegiatan</h5>
                    <div class="#">
                        <button class="btn btn-primary me-3" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#addNews" aria-controls="addNews">
                            + Tambah Kegiatan
                        </button>
                        <div class="offcanvas offcanvas-end w-50" data-bs-scroll="true" tabindex="-1" id="addNews"
                            aria-labelledby="offcanvasBackdropLabel">
                            <div class="offcanvas-header border-bottom">
                                <h5 id="offcanvasBackdropLabel" class="offcanvas-title">Tambah Kegiatan</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body mx-0 flex-grow-0">
                                <form action="{{ route('admin.berita.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="file" class="form-control" name="cover" id="cover"
                                            value="{{ old('cover') }}" placeholder="Gambar Kegiatan" />
                                        <label for="cover">Gambar Kegiatan</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="file" class="form-control" name="thumbnail" id="thumbnail"
                                            value="{{ old('thumbnail') }}" placeholder="Thumbnail Kegiatan" />
                                        <label for="thumbnail">Thumbnail Kegiatan</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="file" class="form-control" name="docum_berita[]" id="docum_berita"
                                            placeholder="Dokumentasi Kegiatan" value="{{ old('docum_berita') }}" multiple />
                                        <label for="docum_berita">Dokumentasi Kegiatan</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input type="text" class="form-control" name="judul" id="judul"
                                            value="{{ old('judul') }}" placeholder="Judul Kegiatan" />
                                        <label for="judul">Judul Kegiatan</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <select class="form-select" name="class_berita" id="class_berita">
                                            <option selected="selected" disabled>-- Pilih Klasifikasi Kegiatan --</option>
                                            <option {{ old('class_berita') == 'harian' ? 'selected' : '' }} value="harian">
                                                Harian</option>
                                            <option {{ old('class_berita') == 'bulanan' ? 'selected' : '' }}
                                                value="bulanan">Bulanan</option>
                                            <option {{ old('class_berita') == 'tahunan' ? 'selected' : '' }}
                                                value="tahunan">Tahunan</option>
                                        </select>
                                        <label for="class_berita">Klasifikasi Kegiatan</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6 row">
                                        <div class="col-6">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" name="tanggal_awal" type="date"
                                                    value="{{ old('tanggal_awal') }}" id="tanggal_awal" />
                                                <label for="tanggal_awal">Tanggal Awal</label>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control" name="tanggal_akhir" type="date"
                                                    value="{{ old('tanggal_akhir') }}" id="tanggal_akhir" />
                                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <textarea id="isi" class="form-control" name="isi" placeholder="Deskripsi Kegiatan" style="height: 100px">{{ old('isi') }}</textarea>
                                        <label for="isi">Deskripsi Kegiatan</label>
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- / Alerts --}}
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="25%">Thumbnail</th>
                                <th width="15%">Judul</th>
                                <th>Isi</th>
                                <th width="10%">Klasifikasi Kegiatan</th>
                                <th>Status</th>
                                <th width="10%">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($berita as $data)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $data->thumbnail) }}"
                                            alt="{{ ucwords($data->judul) }}" class="rounded" style="width: 100%;" />
                                    </td>
                                    <td>{{ ucwords($data->judul) }}</td>
                                    <td>
                                        {{ Str::limit($data->isi, 100, '...') }}
                                    </td>
                                    <td>
                                        {{ $data->class_berita ? ucwords($data->class_berita) : '-' }}
                                    </td>
                                    <td>
                                        @if ($data->is_active)
                                            <span id="status-{{ $data->id }}"
                                                class="badge rounded-pill bg-primary me-1">Terbit</span>
                                        @else
                                            <span id="status-{{ $data->id }}"
                                                class="badge rounded-pill bg-secondary me-1">Arsip</span>
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
                                                    data-bs-target="#addDocumNews-{{ $data->slug }}">
                                                    <i class="ri ri-add-circle-line me-1"></i> Tambah Dokumentasi
                                                </button>
                                                <button class="dropdown-item" data-bs-toggle="offcanvas"
                                                    data-bs-target="#editNews-{{ $data->slug }}">
                                                    <i class="ri ri-pencil-line me-1"></i> Edit
                                                </button>
                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal-{{ $data->slug }}">
                                                    <i class="ri ri-eye-line me-1"></i> View
                                                </button>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.berita.destroy', $data->slug) }}"
                                                    data-confirm-delete="true">
                                                    <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
                                                    Delete
                                                </a>
                                            </div>
                                            <div class="offcanvas offcanvas-end w-50" tabindex="-1"
                                                id="editNews-{{ $data->slug }}">
                                                <div class="offcanvas-header border-bottom">
                                                    <h5>Edit Kegiatan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="offcanvas"></button>
                                                </div>

                                                <div class="offcanvas-body">
                                                    <form action="{{ route('admin.berita.update', $data->slug) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        {{-- Preview Thumbnail lama --}}
                                                        <div class="mb-4">
                                                            <label class="form-label">Thumbnail Terkini</label> <br>
                                                            <center>
                                                                <img src="{{ asset('storage/' . $data->thumbnail) }}"
                                                                    class="w-50 img-fluid rounded">
                                                            </center>
                                                        </div>

                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <input type="file" class="form-control" name="thumbnail"
                                                                id="thumbnail" placeholder="Thumbnail Kegiatan" />
                                                            <label for="thumbnail">Ganti Thumbnail Kegiatan
                                                                (Opsional)
                                                            </label>
                                                        </div>

                                                        {{-- Preview gambar lama --}}
                                                        <div class="mb-4">
                                                            <label class="form-label">Gambar Terkini</label> <br>
                                                            <center>
                                                                <img src="{{ asset('storage/' . $data->cover) }}"
                                                                    class="w-75 img-fluid rounded">
                                                            </center>
                                                        </div>

                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <input type="file" class="form-control" name="cover">
                                                            <label>Ganti Gambar (Opsional)</label>
                                                        </div>

                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <input type="text" class="form-control" name="judul"
                                                                value="{{ $data->judul }}" required>
                                                            <label>Judul Kegiatan</label>
                                                        </div>

                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <select class="form-select" name="class_berita"
                                                                id="class_berita_edit">
                                                                <option selected="selected" disabled>-- Pilih Klasifikasi
                                                                    Kegiatan --</option>
                                                                <option
                                                                    {{ $data->class_berita === 'harian' ? 'selected' : '' }}
                                                                    value="harian">Harian</option>
                                                                <option
                                                                    {{ $data->class_berita === 'bulanan' ? 'selected' : '' }}
                                                                    value="bulanan">Bulanan</option>
                                                                <option
                                                                    {{ $data->class_berita === 'tahunan' ? 'selected' : '' }}
                                                                    value="tahunan">Tahunan</option>
                                                            </select>
                                                            <label for="class_berita_edit">Klasifikasi Kegiatan</label>
                                                        </div>

                                                        <div class="form-floating form-floating-outline mb-6 row">
                                                            <div class="col-6">
                                                                <div class="form-floating form-floating-outline">
                                                                    <input class="form-control" name="tanggal_awal"
                                                                        type="date" id="tanggal_awal"
                                                                        value="{{ $data->tanggal_awal }}" />
                                                                    <label for="tanggal_awal">Tanggal Awal</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-floating form-floating-outline">
                                                                    <input class="form-control" name="tanggal_akhir"
                                                                        type="date" id="tanggal_akhir"
                                                                        value="{{ $data->tanggal_akhir }}" />
                                                                    <label for="tanggal_akhir">Tanggal Akhir</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <textarea class="form-control" name="isi" style="height: 120px" required>{{ $data->isi }}</textarea>
                                                            <label>Isi Kegiatan</label>
                                                        </div>

                                                        <button class="btn btn-primary">Edit</button>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="offcanvas">Batal</button>
                                                    </form>
                                                </div>
                                            </div>

                                            <div class="offcanvas offcanvas-end w-50" tabindex="-1"
                                                id="addDocumNews-{{ $data->slug }}">
                                                <div class="offcanvas-header border-bottom">
                                                    <h5>Tambah Dokumentasi Kegiatan</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="offcanvas"></button>
                                                </div>

                                                <div class="offcanvas-body">
                                                    <form action="{{ route('admin.berita.add.docum', $data->slug) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <input type="file" name="docum_berita[]"
                                                                value="{{ $data->docum_berita }}" class="form-control"
                                                                multiple>
                                                            <label class="form-label">Dokumentasi Kegiatan</label>
                                                        </div>

                                                        <button class="btn btn-primary">Tambah Dokumentasi</button>
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="offcanvas">Batal</button>
                                                    </form>
                                                </div>
                                            </div>

                                            {{-- Modal View Kegiatan --}}
                                            <div class="modal fade" id="viewModal-{{ $data->slug }}" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Detail Kegiatan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <h4>{{ Str::ucfirst($data->judul) }}</h4>

                                                            <center>
                                                                <img src="{{ asset('storage/' . $data->cover) }}"
                                                                    class="img-fluid w-75 rounded mb-3">
                                                            </center>

                                                            {{-- Dokumentasi Kegiatan --}}
                                                            <h5>Dokumentasi Kegiatan</h5>

                                                            @if ($data->docum_berita)
                                                                <div class="swiper gallerySwiper-{{ $data->id }}">
                                                                    <div class="swiper-wrapper">
                                                                        @foreach (json_decode($data->docum_berita) as $docum)
                                                                            <div class="swiper-slide">
                                                                                <img src="{{ asset('storage/' . $docum) }}"
                                                                                    class="img-fluid rounded gallery-thumb"
                                                                                    data-image="{{ asset('storage/' . $docum) }}">
                                                                            </div>
                                                                        @endforeach
                                                                    </div>

                                                                    <!-- Button -->
                                                                    {{-- <div class="swiper-button-next"></div>
                                                                    <div class="swiper-button-prev"></div> --}}
                                                                </div>
                                                            @endif

                                                            <p>
                                                                Tanggal Pelaksanaan:
                                                                {{ \Carbon\Carbon::parse($data->tanggal_awal)->format('d M Y') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($data->tanggal_akhir)->format('d M Y') }}
                                                            </p>

                                                            <p class="text-muted">
                                                                Status:
                                                                <span id="status-badge-{{ $data->id }}"
                                                                    class="badge {{ $data->is_active ? 'bg-primary' : 'bg-secondary' }}">
                                                                    {{ $data->is_active ? 'Terbit' : 'Arsip' }}
                                                                </span>
                                                            </p>

                                                            <p>
                                                                Klasifikasi Kegiatan:
                                                                {{ $data->class_berita ? ucwords($data->class_berita) : '-' }}
                                                            </p>

                                                            <hr>

                                                            <p style="text-align: justify;">
                                                                {{ $data->isi }}
                                                            </p>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button
                                                                class="btn btn-sm toggle-status-btn {{ $data->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                                data-id="{{ $data->id }}">
                                                                {{ $data->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                            </button>
                                                            <button class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Modal View Kegiatan --}}

                                            {{-- Modal Preview Foto --}}
                                            {{-- <div class="modal fade" id="imagePreviewModal" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-body p-0">
                                                            <img id="previewImage" src=""
                                                                class="img-fluid w-100 rounded">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- Modal Preview Foto --}}
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

                    @if ($berita->isEmpty())
                        {{ null }}
                    @else
                        <div style="padding: 2rem 0 0 1rem">
                            {{ $berita->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- / Content -->
    </div>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast text-bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body" id="toastBody">
                    ...
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
@endsection

@section('js-plus')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Swiper(".gallerySwiper-{{ $data->id }}", {
                slidesPerView: 'auto',
                spaceBetween: 15,
                loop: true,
                speed: 5000, // makin besar makin halus
                autoplay: {
                    delay: 0,
                    disableOnInteraction: false
                },
                freeMode: true,
                freeModeMomentum: false,
                grabCursor: true,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
            });
        });
    </script>

    {{-- <script>
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("gallery-thumb")) {
                document.getElementById("previewImage").src =
                    e.target.getAttribute("data-image");
            }
        });
    </script> --}}

    <script>
        function showToast(message, active = true) {

            const toastEl = document.getElementById('liveToast');
            const toastBody = document.getElementById('toastBody');

            toastBody.textContent = message;

            toastEl.classList.toggle('text-bg-success', active);
            toastEl.classList.toggle('text-bg-secondary', !active);

            new bootstrap.Toast(toastEl).show();
        }

        document.addEventListener("click", function(e) {

            if (e.target.classList.contains("toggle-status-btn")) {

                const btn = e.target;
                const id = btn.dataset.id;

                fetch(`/cms-admin/news/status/${id}/toggle`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        // ===== UPDATE BADGE =====
                        const badge = document.getElementById(`status-badge-${id}`);
                        const statusBadge = document.getElementById(`status-${id}`);

                        badge.classList.toggle("bg-primary", data.is_active);
                        badge.classList.toggle("bg-secondary", !data.is_active);
                        badge.textContent = data.is_active ? 'Terbit' : 'Arsip';

                        statusBadge.classList.toggle("bg-primary", data.is_active);
                        statusBadge.classList.toggle("bg-secondary", !data.is_active);
                        statusBadge.textContent = data.is_active ? 'Terbit' : 'Arsip';

                        // ===== UPDATE BUTTON =====
                        btn.classList.toggle("btn-success", !data.is_active);
                        btn.classList.toggle("btn-secondary", data.is_active);
                        btn.textContent = data.is_active ? 'Nonaktifkan' : 'Aktifkan';

                        showToast(data.text, data.is_active);
                    })
                    .catch(err => console.error(err));
            }

        });
    </script>
@endsection
