@extends('layout.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Edit User</h3>
                    </div>

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" value="{{ $user->nama }}">
                            </div>

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" value="{{ $user->username }}">
                            </div>

                            <div class="form-group">
                                <label>Password (opsional)</label>
                                <input type="password" class="form-control" name="password" placeholder="Isi jika ingin mengubah password">
                            </div>

                            <div class="form-group">
                                <label>Role</label>

                                <select class="form-control" disabled>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="perpajakan" {{ $user->role == 'perpajakan' ? 'selected' : '' }}>Perpajakan</option>
                                    <option value="perizinan" {{ $user->role == 'perizinan' ? 'selected' : '' }}>Perizinan</option>
                                </select>

                                <!-- hidden agar tetap terkirim -->
                                <input type="hidden" name="role" value="{{ $user->role }}">
                            </div>


                            <div class="form-group">
                                <label>Status</label>

                                <select class="form-control" disabled>
                                    <option value="approved" {{ $user->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>

                                <!-- hidden agar tetap terkirim -->
                                <input type="hidden" name="status" value="{{ $user->status }}">
                            </div>


                        </div>

                        <div class="card-footer">
                            <button class="btn btn-warning">Update</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection