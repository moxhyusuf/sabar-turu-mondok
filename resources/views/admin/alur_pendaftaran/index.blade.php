@extends('layout.app')

@section('title', 'Alur Pendaftaran')
@section('page-title', 'Alur Pendaftaran')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">


                    {{-- Alert sukses --}}
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
                                    <th class="text-center" width="60px">No</th>
                                    <th width="200px">Gambar</th>
                                    <th class="text-center" width="150px">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($data as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>

                                    {{-- Gambar --}}
                                    <td>
                                        @if($item->img)
                                        <img src="{{ asset('storage/'.$item->img) }}" width="150" class="img-thumbnail">
                                        @else
                                        <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="text-center">
                                        <a href="{{ route('alur_pendaftaran.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>


                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data.</td>
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

{{-- Auto close alert --}}
<script>
    setTimeout(() => {
        $('.alert').alert('close');
    }, 3000);
</script>

@endsection