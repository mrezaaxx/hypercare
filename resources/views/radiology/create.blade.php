@extends('layouts.app')

@section('title', 'Order Radiologi Baru - hypercare')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">Radiologi</p>
            <h1 class="page-title">Order Pemeriksaan Baru</h1>
        </div>
        <a href="{{ route('radiology-orders.index') }}" class="btn btn-secondary">Kembali</a>
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

        <form method="POST" action="{{ route('radiology-orders.store') }}" class="form-grid">
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
                <label for="exam_type">Jenis Pemeriksaan <span class="required">*</span></label>
                <select id="exam_type" name="exam_type" required>
                    <option value="">-- Pilih Jenis --</option>
                    @foreach(['X-Ray', 'CT-Scan', 'MRI', 'USG', 'Mammografi', 'Fluoroskopi', 'Lainnya'] as $type)
                        <option value="{{ $type }}" {{ old('exam_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="body_part">Bagian Tubuh</label>
                <input type="text" id="body_part" name="body_part" value="{{ old('body_part') }}" placeholder="Contoh: Thorax, Abdomen, Kepala">
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
                <button type="submit" class="btn btn-primary" id="btn-simpan-rad">Buat Order Radiologi</button>
                <a href="{{ route('radiology-orders.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
