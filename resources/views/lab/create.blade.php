@extends('layouts.app')

@section('title', 'Order Lab Baru - hypercare')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">Laboratorium</p>
            <h1 class="page-title">Order Pemeriksaan Baru</h1>
        </div>
        <a href="{{ route('lab-orders.index') }}" class="btn btn-secondary">Kembali</a>
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

        <form method="POST" action="{{ route('lab-orders.store') }}" class="form-grid">
            @csrf

            <div class="form-group">
                <label for="order_number">No. Order</label>
                <input type="text" id="order_number" value="{{ $nextOrderNumber }}" disabled class="input-disabled">
                <small>Nomor dihasilkan otomatis</small>
            </div>

            <div class="form-group">
                <label for="patient_id">Pasien <span class="required">*</span></label>
                <select id="patient_id" name="patient_id" required>
                    <option value="">-- Pilih Pasien --</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->medical_record_number }} - {{ $patient->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="test_type">Jenis Pemeriksaan <span class="required">*</span></label>
                <select id="test_type" name="test_type" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach(['Hematologi Lengkap', 'Kimia Darah', 'Urinalisa', 'Serologi', 'Gula Darah', 'Profil Lipid', 'Fungsi Hati', 'Fungsi Ginjal', 'Elektrolit', 'Koagulasi', 'Lainnya'] as $type)
                        <option value="{{ $type }}" {{ old('test_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="priority">Prioritas <span class="required">*</span></label>
                <select id="priority" name="priority" required>
                    <option value="Normal" {{ old('priority', 'Normal') == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Cito" {{ old('priority') == 'Cito' ? 'selected' : '' }}>Cito (Urgent)</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label for="clinical_notes">Catatan Klinis</label>
                <textarea id="clinical_notes" name="clinical_notes" rows="3" placeholder="Indikasi klinis, diagnosis kerja, dll.">{{ old('clinical_notes') }}</textarea>
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-primary" id="btn-simpan-lab">Buat Order Lab</button>
                <a href="{{ route('lab-orders.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
