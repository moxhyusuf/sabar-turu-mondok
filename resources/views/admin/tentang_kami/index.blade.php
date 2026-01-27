@extends('layout.app')

@section('title', 'Tentang Kami')
@section('page-title', 'Tentang Kami')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header bg-seconday text-dark">
                        <h5 class="mb-2"></h5>
                    </div>

                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="card-body">


                        <table class="table table-bordered table-hover">
                            <thead class="table-secondary">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Deskripsi</th>
                                    <th>Gambar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($data as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>

                                    {{-- sesuai field database: tentang_kami --}}
                                    <td>{{ Str::limit($item->tentang_kami, 80) }}</td>

                                    {{-- sesuai field database: img --}}
                                    <td>
                                        @if($item->img)
                                        <img src="{{ asset('storage/'.$item->img) }}" width="120">
                                        @else
                                        <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('tentang_kami.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>


                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    setTimeout(() => {
        $('.alert').alert('close');
    }, 3000);
</script>

@endsection