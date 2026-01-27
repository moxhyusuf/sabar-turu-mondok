@extends('layout.app')

@section('title', 'Edit Tentang Kami')


@section('content')
<div class="container mt-4">
    <div class="card p-4 shadow-sm">
        <h3 class="mb-4">Edit Tentang Kami</h3>

        <form action="{{ route('tentang_kami.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- INPUT TENTANG KAMI --}}
            <div class="form-group mb-4">
                <label class="font-weight-bold">Deskripsi Tentang Kami</label>
                <textarea name="tentang_kami" class="form-control" rows="6" required>{{ old('tentang_kami', $data->tentang_kami) }}</textarea>

                @error('tentang_kami')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- GAMBAR LAMA --}}
            <div class="mb-4">
                <label class="font-weight-bold d-block">Gambar Lama</label>

                @if ($data->img)
                <img src="{{ asset('storage/'.$data->img) }}"
                    class="img-fluid rounded border"
                    width="250">

                <p class="mt-2 text-muted">
                    Gambar ini akan dihapus jika kamu mengupload gambar baru.
                </p>
                @else
                <p class="text-muted">Belum ada gambar.</p>
                @endif
            </div>

            {{-- UPLOAD GAMBAR BARU --}}
            <div class="form-group mb-4">
                <label class="font-weight-bold">Upload Gambar Baru (Opsional)</label>
                <input type="file" name="img" class="form-control">

                @error('img')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('tentang_kami.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection