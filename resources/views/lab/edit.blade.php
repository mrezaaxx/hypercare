@extends('layouts.app')

@section('title', 'Edit Order Lab - hypercare')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">Laboratorium</p>
            <h1 class="page-title">Edit Order & Hasil Lab</h1>
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

        <form method="POST" action="{{ route('lab-orders.update', $labOrder) }}" class="form-grid">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="order_number">No. Order</label>
                <input type="text" id="order_number" value="{{ $labOrder->order_number }}" disabled class="input-disabled">
            </div>

            <div class="form-group">
                <label>Pasien</label>
                <input type="text" value="{{ $labOrder->patient->medical_record_number }} - {{ $labOrder->patient->name }}" disabled class="input-disabled">
            </div>

            <div class="form-group">
                <label for="test_type">Jenis Pemeriksaan <span class="required">*</span></label>
                <select id="test_type" name="test_type" required>
                    @foreach(['Hematologi Lengkap', 'Kimia Darah', 'Urinalisa', 'Serologi', 'Gula Darah', 'Profil Lipid', 'Fungsi Hati', 'Fungsi Ginjal', 'Elektrolit', 'Koagulasi', 'Lainnya'] as $type)
                        <option value="{{ $type }}" {{ old('test_type', $labOrder->test_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="priority">Prioritas <span class="required">*</span></label>
                <select id="priority" name="priority" required>
                    <option value="Normal" {{ old('priority', $labOrder->priority) == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Cito" {{ old('priority', $labOrder->priority) == 'Cito' ? 'selected' : '' }}>Cito (Urgent)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" required>
                    <option value="Menunggu" {{ old('status', $labOrder->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ old('status', $labOrder->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ old('status', $labOrder->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label for="clinical_notes">Catatan Klinis</label>
                <textarea id="clinical_notes" name="clinical_notes" rows="3">{{ old('clinical_notes', $labOrder->clinical_notes) }}</textarea>
            </div>

            <div class="form-section-title full-width">
                <h3>Hasil Pemeriksaan</h3>
                <p class="text-muted">Isi hasil setelah pemeriksaan selesai</p>
            </div>

            <div class="form-group full-width">
                <label for="result_value">Nilai Hasil</label>
                <textarea id="result_value" name="result_value" rows="4" placeholder="Masukkan nilai hasil pemeriksaan...">{{ old('result_value', $labOrder->result_value) }}</textarea>
            </div>

            <div class="form-group full-width">
                <label for="result_notes">Catatan Hasil</label>
                <textarea id="result_notes" name="result_notes" rows="3" placeholder="Interpretasi atau catatan tambahan...">{{ old('result_notes', $labOrder->result_notes) }}</textarea>
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-primary" id="btn-update-lab">Perbarui Order Lab</button>
                <a href="{{ route('lab-orders.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
