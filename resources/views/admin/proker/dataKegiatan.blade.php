<!DOCTYPE html>
<html lang="zxx">
@include('layouts.head')
<style>
    .btn-check:checked + .btn-outline-light {
        background-color: #ff4500 !important;
        border-color: #ff4500 !important;
        color: white !important;
    }
    .icon-selector-wrapper::-webkit-scrollbar {
        width: 6px;
    }
    .icon-selector-wrapper::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
</style>
<body>
@include('components.sidebar')
@include('components.header')
<main class="nxl-container">
    <div class="card-body p-4">
        <h4 class="mb-3">Data Kegiatan</h4>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $item)
                        <tr>
                            <td>
                                @if($item->photo)
                                    <img src="{{ asset('frontendpartials/assets/img/gallery/'.$item->photo) }}" 
                                         width="80" class="rounded">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>{{ $item->title }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->event_date }}</td>

                            <td>

                                <!-- EDIT -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <!-- DELETE -->
                                <form action="{{ route('kegiatan.destroy', $item->id) }}" 
                                      method="POST" 
                                      style="display:inline-block">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus data ini?')" 
                                            class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Belum ada data kegiatan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</main>

<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('kegiatan.update', $item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" value="{{ $item->title }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Kategori</label>
                        <select name="category" class="form-select">
                            <option value="pendidikan" {{ $item->category=='pendidikan'?'selected':'' }}>Pendidikan</option>
                            <option value="advokasi" {{ $item->category=='advokasi'?'selected':'' }}>Advokasi</option>
                            <option value="kesejahteraan" {{ $item->category=='kesejahteraan'?'selected':'' }}>Kesejahteraan</option>
                            <option value="sosial" {{ $item->category=='sosial'?'selected':'' }}>Sosial</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" name="event_date" value="{{ $item->event_date }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control">{{ $item->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Ganti Foto (optional)</label>
                        <input type="file" name="photo" class="form-control">
                    </div>

                    @if($item->photo)
                        <img src="{{ asset('frontendpartials/assets/img/gallery/'.$item->photo) }}" width="100">
                    @endif

                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('components.script')
<script>
</script>
</body>
</html>