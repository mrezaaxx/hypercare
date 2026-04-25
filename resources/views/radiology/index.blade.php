@extends('layouts.app')

@section('title', 'Radiologi - hypercare')

@section('content')
    <div class="page-header">
        <div>
            <p class="eyebrow">Radiologi</p>
            <h1 class="page-title">Daftar Order Radiologi</h1>
        </div>
        <a href="{{ route('radiology-orders.create') }}" class="btn btn-primary" id="btn-tambah-rad">+ Order Baru</a>
    </div>

    <div class="card">
        <div class="filter-bar">
            <form method="GET" action="{{ route('radiology-orders.index') }}" class="search-bar">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. order atau nama pasien..." id="search-rad">
                <button type="submit" class="btn btn-primary btn-sm">Cari</button>
            </form>
            <div class="status-filters">
                <a href="{{ route('radiology-orders.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-secondary' }}">Semua</a>
                <a href="{{ route('radiology-orders.index', ['status' => 'Menunggu']) }}" class="btn btn-sm {{ request('status') == 'Menunggu' ? 'btn-primary' : 'btn-secondary' }}">Menunggu</a>
                <a href="{{ route('radiology-orders.index', ['status' => 'Diproses']) }}" class="btn btn-sm {{ request('status') == 'Diproses' ? 'btn-primary' : 'btn-secondary' }}">Diproses</a>
                <a href="{{ route('radiology-orders.index', ['status' => 'Selesai']) }}" class="btn btn-sm {{ request('status') == 'Selesai' ? 'btn-primary' : 'btn-secondary' }}">Selesai</a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Pasien</th>
                        <th>No. RM</th>
                        <th>Jenis</th>
                        <th>Bagian Tubuh</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->patient->name }}</td>
                            <td>{{ $order->patient->medical_record_number }}</td>
                            <td>{{ $order->exam_type }}</td>
                            <td>{{ $order->body_part ?? '-' }}</td>
                            <td>
                                <span class="badge {{ $order->priority == 'Cito' ? 'badge-cito' : 'badge-normal' }}">
                                    {{ $order->priority }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-status-{{ strtolower($order->status == 'Menunggu' ? 'menunggu' : ($order->status == 'Diproses' ? 'diproses' : 'selesai')) }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="action-cell">
                                <a href="{{ route('radiology-orders.edit', $order) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form method="POST" action="{{ route('radiology-orders.destroy', $order) }}" class="inline-form" onsubmit="return confirm('Hapus order radiologi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="empty-state">Belum ada order radiologi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="pagination-wrap">
                {{ $orders->appends(request()->query())->links('pagination.simple') }}
            </div>
        @endif
    </div>
@endsection
