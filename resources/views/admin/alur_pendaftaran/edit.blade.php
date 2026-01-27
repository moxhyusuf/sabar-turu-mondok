@extends('layout.app')

@section('title', 'Edit Alur Pendaftaran')
@section('page-title', 'Edit Alur Pendaftaran')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Edit Alur Pendaftaran</h3>
                    </div>

                    <form action="{{ route('alur_pendaftaran.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            {{-- Tampilkan gambar lama --}}
                            <div class="form-group">
                                <label>Gambar Saat Ini</label><br>

                                @if ($data->img)
                                <img src="{{ asset('storage/'.$data->img) }}" width="200" class="img-thumbnail mb-2">
                                @else
                                <p class="text-muted">Tidak ada gambar</p>
                                @endif
                            </div>

                            {{-- Upload gambar baru --}}
                            <div class="form-group">
                                <label>Upload Gambar Baru (Opsional)</label>
                                <input type="file" name="img" class="form-control">

                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button class="btn btn-warning">Update</button>
                            <a href="{{ route('alur_pendaftaran.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection