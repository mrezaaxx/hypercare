@extends('layouts.app')

@section('title', 'hypercare')

@section('content')
    <header class="hero">
        <div class="hero-copy-block">
            <p class="eyebrow">Operational Workspace</p>
            <h1>hypercare untuk alur klinis, operasional, dan interoperabilitas rumah sakit.</h1>
            <p class="hero-copy">
                Rancangan ini memusatkan registrasi pasien, antrean layanan, ringkasan klinis, dan monitoring integrasi
                SATUSEHAT, BPJS Kesehatan, PACS, serta LIS dalam satu dashboard berbasis web.
            </p>
            <div class="hero-actions">
                <a href="#overview" class="btn btn-primary">Lihat dashboard</a>
                <a href="#integrations" class="btn btn-secondary">Cek integrasi</a>
            </div>
        </div>
        <aside class="hero-panel">
            <div class="panel-head">
                <span class="panel-label">Status Command Center</span>
                <span class="pill pill-live">Live</span>
            </div>
            <div class="panel-grid">
                <div>
                    <strong>{{ $summary['registeredPatients'] }}</strong>
                    <span>Total pasien</span>
                </div>
                <div>
                    <strong>{{ $summary['pendingLabOrders'] }}</strong>
                    <span>Order lab aktif</span>
                </div>
                <div>
                    <strong>{{ $summary['pendingRadiologyOrders'] }}</strong>
                    <span>Order radiologi aktif</span>
                </div>
                <div>
                    <strong>{{ $summary['completedOrders'] }}</strong>
                    <span>Order selesai</span>
                </div>
            </div>
        </aside>
    </header>

    <main class="dashboard">
        <section id="overview" class="card">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Overview</p>
                    <h2>Situasi layanan rumah sakit saat ini</h2>
                </div>
                <button type="button" class="live-indicator" data-toggle-highlight>Live monitoring</button>
            </div>
            <div class="stats-grid">
                <article class="stat-card accent-blue">
                    <span>Total pasien</span>
                    <strong>{{ $summary['registeredPatients'] }}</strong>
                    <p>Basis data pasien aktif untuk prototipe SIMRS.</p>
                </article>
                <article class="stat-card accent-green">
                    <span>Order LIS aktif</span>
                    <strong>{{ $summary['pendingLabOrders'] }}</strong>
                    <p>Order laboratorium dengan status menunggu atau diproses.</p>
                </article>
                <article class="stat-card accent-orange">
                    <span>Order PACS aktif</span>
                    <strong>{{ $summary['pendingRadiologyOrders'] }}</strong>
                    <p>Order radiologi yang masih berjalan pada workflow klinis.</p>
                </article>
                <article class="stat-card accent-red">
                    <span>Order selesai</span>
                    <strong>{{ $summary['completedOrders'] }}</strong>
                    <p>Hasil penunjang yang sudah selesai dan siap dipakai.</p>
                </article>
            </div>
        </section>

        <section class="split-layout">
            <article class="card">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Patient Flow</p>
                        <h2>Daftar pasien prioritas</h2>
                    </div>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>Layanan</th>
                                <th>Pembiayaan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                <tr>
                                    <td><span class="mono">{{ $patient['mrn'] }}</span></td>
                                    <td>{{ $patient['name'] }}</td>
                                    <td>{{ $patient['service'] }}</td>
                                    <td>{{ $patient['payer'] }}</td>
                                    <td><span class="badge">{{ $patient['status'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="card">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Workflow</p>
                        <h2>Alur integrasi utama</h2>
                    </div>
                </div>
                <ol class="timeline">
                    @foreach ($timeline as $step)
                        <li><span>{{ $step }}</span></li>
                    @endforeach
                </ol>
            </article>
        </section>

        <section id="integrations" class="card">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Interoperability Hub</p>
                    <h2>Monitoring integrasi eksternal</h2>
                </div>
            </div>
            <div class="integration-grid">
                @foreach ($integrations as $integration)
                    <article class="integration-card">
                        <div class="integration-header">
                            <h3>{{ $integration['name'] }}</h3>
                            <span class="pill">{{ $integration['status'] }}</span>
                        </div>
                        <p>{{ $integration['description'] }}</p>
                        <strong>{{ $integration['metric'] }}</strong>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="split-layout">
            <article class="card">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Clinical Workspace</p>
                        <h2>Panel dokter dan penunjang</h2>
                    </div>
                </div>
                <div class="feature-list">
                    <div>
                        <h3>EMR Ringkas</h3>
                        <p>Alergi, diagnosis aktif, medication list, dan hasil penunjang tampil dalam satu layar.</p>
                    </div>
                    <div>
                        <h3>Radiologi via PACS</h3>
                        <p>Preview hasil baca, status approval, dan tautan studi radiologi prioritas.</p>
                    </div>
                    <div>
                        <h3>Laboratorium via LIS</h3>
                        <p>Hasil kritis ditandai otomatis dan dikirim ke dashboard dokter jaga.</p>
                    </div>
                </div>
            </article>

            <article class="card">
                <div class="section-heading">
                    <div>
                        <p class="eyebrow">Administrative Control</p>
                        <h2>Panel operasional rumah sakit</h2>
                    </div>
                </div>
                <div class="feature-list compact">
                    <div>
                        <h3>Manajemen antrean</h3>
                        <p>Pisahkan antrean poli, farmasi, laboratorium, dan radiologi.</p>
                    </div>
                    <div>
                        <h3>Bridging BPJS</h3>
                        <p>Validasi peserta, rujukan, SEP, dan status klaim secara terpusat.</p>
                    </div>
                    <div>
                        <h3>SATUSEHAT queue</h3>
                        <p>Retry sinkronisasi untuk resource yang gagal dengan audit trail.</p>
                    </div>
                </div>
            </article>
        </section>
    </main>
@endsection
