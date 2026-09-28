@extends('adminlte::page')

@section('title', 'Edit Siswa')

@section('content_header')
    <h1>Edit Siswa</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            <form action="{{ route('siswa.update', $siswa->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Nama Siswa --}}
                <div class="form-group">
                    <label for="nama_siswa">Nama Siswa</label>

                    <input type="text"
                           name="nama_siswa"
                           class="form-control @error('nama_siswa') is-invalid @enderror"
                           id="nama_siswa"
                           value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                           required>

                    @error('nama_siswa')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- NIS --}}
                <div class="form-group">
                    <label for="nis">Nis</label>

                    <input type="text"
                           name="nis"
                           class="form-control @error('nis') is-invalid @enderror"
                           id="nis"
                           value="{{ old('nis', $siswa->nis) }}"
                           required>

                    @error('nis')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Jurusan --}}
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>

                    <input type="text"
                           name="jurusan"
                           class="form-control @error('jurusan') is-invalid @enderror"
                           id="jurusan"
                           value="{{ old('jurusan', $siswa->jurusan) }}"
                           required>

                    @error('jurusan')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Kelas --}}
                <div class="form-group">
                    <label for="kelas">Kelas</label>

                    <input type="text"
                           name="kelas"
                           class="form-control @error('kelas') is-invalid @enderror"
                           id="kelas"
                           value="{{ old('kelas', $siswa->kelas) }}"
                           required>

                    @error('kelas')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email</label>

                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           id="email"
                           value="{{ old('email', $siswa->email) }}">

                    @error('email')
                        <span class="text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Foto Siswa --}}
                <div class="form-group">
                    <label for="foto">Foto Siswa</label>

                    {{-- Foto lama --}}
                    @if($siswa->foto)
                        <div class="mb-2">
                            <p class="text-muted mb-1">
                                Foto saat ini:
                            </p>

                            <img src="{{ asset('storage/' . $siswa->foto) }}"
                                 alt="Foto {{ $siswa->nama_siswa }}"
                                 class="img-thumbnail"
                                 style="width: 150px;">
                        </div>
                    @endif

                    {{-- Upload foto baru --}}
                    <input type="file"
                           name="foto"
                           class="form-control-file @error('foto') is-invalid @enderror"
                           id="foto"
                           accept=".jpg,.jpeg,.png">

                    <small class="form-text text-muted">
                        Biarkan kosong jika tidak ingin mengubah foto.
                        Format: JPG, JPEG, PNG. Maksimal 2MB.
                    </small>

                    @error('foto')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- Tombol --}}
                <button type="submit" class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('siswa.index') }}"
                   class="btn btn-secondary">
                    Batal
                </a>

            </form>

        </div>
    </div>
@stop