@extends('layout.app')

@section('title', 'Alur Pendaftaran')
@section('page-title', 'Alur Pendaftaran')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            
                {{-- Alert sukses --}}
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
                @endif
                
                {{-- Alert error --}}
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
                @endif

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Alur Pendaftaran</h3>
                    </div>

                    <form action="{{ route('alur_pendaftaran.update_all') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="row">
                                {{-- SECTION 1: ALUR RUMAH PEMONDOKAN --}}
                                <div class="col-md-6 border-right">
                                    <h5 class="font-weight-bold text-primary mb-3">1. {{ $alurPemondokan->title }}</h5>
                                    
                                    {{-- Existing Image --}}
                                    <div class="form-group">
                                        <label>Gambar Alur Saat Ini</label><br>
                                        @if ($alurPemondokan->img)
                                            <div class="position-relative d-inline-block">
                                                <img src="{{ asset('storage/'.$alurPemondokan->img) }}" width="100%" class="img-thumbnail mb-2" style="max-width: 300px; max-height: 250px; object-fit: contain;">
                                                <div class="mt-2 mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="remove_pemondokan" name="remove_pemondokan" value="1">
                                                        <label class="custom-control-label text-danger font-weight-normal" for="remove_pemondokan">Hapus gambar ini</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-muted"><i class="fas fa-image mr-1"></i> Tidak ada gambar alur</p>
                                        @endif
                                    </div>

                                    {{-- File Input --}}
                                    <div class="form-group">
                                        <label for="img_pemondokan">Unggah Gambar Baru / Ganti Gambar</label>
                                        <input type="file" name="img_pemondokan" id="img_pemondokan" class="form-control" onchange="previewPemondokan(event)">
                                        <small class="text-muted">Format: JPG, JPEG, PNG, WEBP. Maksimal 5MB.</small>
                                    </div>

                                    {{-- New Image Preview --}}
                                    <div class="form-group" id="preview_pemondokan_container" style="display: none;">
                                        <label>Preview Gambar Baru</label><br>
                                        <img id="preview_pemondokan_img" src="#" alt="Preview" class="img-thumbnail" style="max-width: 250px; max-height: 200px; object-fit: contain;">
                                    </div>
                                </div>

                                {{-- SECTION 2: ALUR PENYEWAAN KOS --}}
                                <div class="col-md-6">
                                    <h5 class="font-weight-bold text-primary mb-3">2. {{ $alurKos->title }}</h5>
                                    
                                    {{-- Existing Image --}}
                                    <div class="form-group">
                                        <label>Gambar Alur Saat Ini</label><br>
                                        @if ($alurKos->img)
                                            <div class="position-relative d-inline-block">
                                                <img src="{{ asset('storage/'.$alurKos->img) }}" width="100%" class="img-thumbnail mb-2" style="max-width: 300px; max-height: 250px; object-fit: contain;">
                                                <div class="mt-2 mb-3">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="remove_kos" name="remove_kos" value="1">
                                                        <label class="custom-control-label text-danger font-weight-normal" for="remove_kos">Hapus gambar ini</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-muted"><i class="fas fa-image mr-1"></i> Tidak ada gambar alur</p>
                                        @endif
                                    </div>

                                    {{-- File Input --}}
                                    <div class="form-group">
                                        <label for="img_kos">Unggah Gambar Baru / Ganti Gambar</label>
                                        <input type="file" name="img_kos" id="img_kos" class="form-control" onchange="previewKos(event)">
                                        <small class="text-muted">Format: JPG, JPEG, PNG, WEBP. Maksimal 5MB.</small>
                                    </div>

                                    {{-- New Image Preview --}}
                                    <div class="form-group" id="preview_kos_container" style="display: none;">
                                        <label>Preview Gambar Baru</label><br>
                                        <img id="preview_kos_img" src="#" alt="Preview" class="img-thumbnail" style="max-width: 250px; max-height: 200px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                                <i class="fas fa-save mr-1"></i> Perbarui Alur Pendaftaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    function previewPemondokan(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
            var output = document.getElementById('preview_pemondokan_img');
            output.src = dataURL;
            document.getElementById('preview_pemondokan_container').style.display = 'block';
        };
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewKos(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function(){
            var dataURL = reader.result;
            var output = document.getElementById('preview_kos_img');
            output.src = dataURL;
            document.getElementById('preview_kos_container').style.display = 'block';
        };
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto hide alert
    setTimeout(() => {
        $('.alert').alert('close');
    }, 5000);
</script>
@endpush