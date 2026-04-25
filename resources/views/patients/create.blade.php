@extends('layouts.app')

@section('title', 'Tambah Pasien - hypercare')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">Pendaftaran Pasien</p>
            <h1 class="page-title">Tambah Pasien Baru</h1>
        </div>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        @if ($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('patients.store') }}" class="form-grid">
            @csrf

            <div class="form-group">
                <label for="medical_record_number">No. Rekam Medis</label>
                <input type="text" id="medical_record_number" value="{{ $nextMrn }}" disabled class="input-disabled">
                <small>Nomor dihasilkan otomatis</small>
            </div>

            <div class="form-group">
                <label for="name">Nama Lengkap <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap pasien">
            </div>

            <div class="form-group">
                <label for="nik">NIK (16 digit)</label>
                <input type="text" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" placeholder="Masukkan NIK">
            </div>

            <div class="form-group">
                <label for="birth_date">Tanggal Lahir</label>
                <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
            </div>

            <div class="form-group">
                <label for="gender">Jenis Kelamin <span class="required">*</span></label>
                <select id="gender" name="gender" required>
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="blood_type">Golongan Darah</label>
                <select id="blood_type" name="blood_type">
                    @foreach(['A', 'B', 'AB', 'O', '-'] as $bt)
                        <option value="{{ $bt }}" {{ old('blood_type', '-') == $bt ? 'selected' : '' }}>{{ $bt == '-' ? 'Belum diketahui' : $bt }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="phone">No. Telepon</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-group">
                <label for="insurance_type">Jenis Pembiayaan <span class="required">*</span></label>
                <select id="insurance_type" name="insurance_type" required>
                    <option value="Umum" {{ old('insurance_type', 'Umum') == 'Umum' ? 'selected' : '' }}>Umum</option>
                    <option value="BPJS" {{ old('insurance_type') == 'BPJS' ? 'selected' : '' }}>BPJS</option>
                    <option value="Asuransi" {{ old('insurance_type') == 'Asuransi' ? 'selected' : '' }}>Asuransi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="insurance_number">No. Asuransi / BPJS</label>
                <input type="text" id="insurance_number" name="insurance_number" value="{{ old('insurance_number') }}" placeholder="Nomor kartu asuransi">
            </div>

            <div class="form-group full-width">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" rows="3" placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-primary" id="btn-simpan-pasien">Simpan Data Pasien</button>
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
