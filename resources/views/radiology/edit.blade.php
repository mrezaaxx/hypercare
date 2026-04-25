@extends('layouts.app')

@section('title', 'Edit Order Radiologi - hypercare')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">Radiologi</p>
            <h1 class="page-title">Edit Order & Hasil Radiologi</h1>
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

        <form method="POST" action="{{ route('radiology-orders.update', $radiologyOrder) }}" class="form-grid">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="order_number">No. Order</label>
                <input type="text" id="order_number" value="{{ $radiologyOrder->order_number }}" disabled class="input-disabled">
            </div>

            <div class="form-group">
                <label>Pasien</label>
                <input type="text" value="{{ $radiologyOrder->patient->medical_record_number }} - {{ $radiologyOrder->patient->name }}" disabled class="input-disabled">
            </div>

            <div class="form-group">
                <label for="exam_type">Jenis Pemeriksaan <span class="required">*</span></label>
                <select id="exam_type" name="exam_type" required>
                    @foreach(['X-Ray', 'CT-Scan', 'MRI', 'USG', 'Mammografi', 'Fluoroskopi', 'Lainnya'] as $type)
                        <option value="{{ $type }}" {{ old('exam_type', $radiologyOrder->exam_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="body_part">Bagian Tubuh</label>
                <input type="text" id="body_part" name="body_part" value="{{ old('body_part', $radiologyOrder->body_part) }}">
            </div>

            <div class="form-group">
                <label for="priority">Prioritas <span class="required">*</span></label>
                <select id="priority" name="priority" required>
                    <option value="Normal" {{ old('priority', $radiologyOrder->priority) == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Cito" {{ old('priority', $radiologyOrder->priority) == 'Cito' ? 'selected' : '' }}>Cito (Urgent)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" required>
                    <option value="Menunggu" {{ old('status', $radiologyOrder->status) == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ old('status', $radiologyOrder->status) == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ old('status', $radiologyOrder->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label for="clinical_notes">Catatan Klinis</label>
                <textarea id="clinical_notes" name="clinical_notes" rows="3">{{ old('clinical_notes', $radiologyOrder->clinical_notes) }}</textarea>
            </div>

            <div class="form-section-title full-width">
                <h3>Hasil Pemeriksaan</h3>
                <p class="text-muted">Isi hasil setelah pemeriksaan selesai</p>
            </div>

            <div class="form-group full-width">
                <label for="result_findings">Findings (Temuan)</label>
                <textarea id="result_findings" name="result_findings" rows="4" placeholder="Deskripsi temuan radiologis...">{{ old('result_findings', $radiologyOrder->result_findings) }}</textarea>
            </div>

            <div class="form-group full-width">
                <label for="result_impression">Impression (Kesan)</label>
                <textarea id="result_impression" name="result_impression" rows="3" placeholder="Kesan / kesimpulan radiologis...">{{ old('result_impression', $radiologyOrder->result_impression) }}</textarea>
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-primary" id="btn-update-rad">Perbarui Order Radiologi</button>
                <a href="{{ route('radiology-orders.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection
