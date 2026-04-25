@extends('layouts.app')

@section('title', 'Pendaftaran Pasien - hypercare')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">Pendaftaran Pasien</p>
            <h1 class="page-title">Daftar Pasien</h1>
        </div>
        <a href="{{ route('patients.create') }}" class="btn btn-primary" id="btn-tambah-pasien">+ Tambah Pasien</a>
    </div>

    <div class="card">
        <form method="GET" action="{{ route('patients.index') }}" class="search-bar">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, No. RM, atau NIK..." id="search-pasien">
            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            @if(request('search'))
                <a href="{{ route('patients.index') }}" class="btn btn-secondary btn-sm">Reset</a>
            @endif
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No. RM</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Gender</th>
                        <th>Tgl Lahir</th>
                        <th>Pembiayaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($patients as $patient)
                        <tr>
                            <td><strong>{{ $patient->medical_record_number }}</strong></td>
                            <td>{{ $patient->name }}</td>
                            <td>{{ $patient->nik ?? '-' }}</td>
                            <td>{{ $patient->gender }}</td>
                            <td>{{ $patient->birth_date ? $patient->birth_date->format('d/m/Y') : '-' }}</td>
                            <td><span class="badge badge-{{ strtolower($patient->insurance_type) }}">{{ $patient->insurance_type }}</span></td>
                            <td class="action-cell">
                                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form method="POST" action="{{ route('patients.destroy', $patient) }}" class="inline-form" onsubmit="return confirm('Hapus data pasien ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">Belum ada data pasien.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($patients->hasPages())
            <div class="pagination-wrap">
                {{ $patients->appends(request()->query())->links('pagination.simple') }}
            </div>
        @endif
    </div>
@endsection
