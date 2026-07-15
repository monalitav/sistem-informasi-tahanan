<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Tahanan</title>
    <style>
        @page {
            margin: 100px 40px 90px 40px;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 11px;
            color: #111;
        }

        header {
            position: fixed;
            top: -85px;
            left: 0;
            right: 0;
            height: 85px;
        }

        footer {
            position: fixed;
            bottom: -70px;
            left: 0;
            right: 0;
            height: 70px;
            font-size: 9px;
            text-align: center;
            color: #555;
            border-top: 1px solid #999;
            padding-top: 4px;
        }

        .kop-table {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 6px;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 70px;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text .instansi {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .kop-text .alamat {
            font-size: 10px;
            margin: 2px 0 0 0;
        }

        h1.title {
            text-align: center;
            font-size: 13px;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 18px 0 4px 0;
        }

        .filter-info {
            text-align: center;
            font-size: 10px;
            margin-bottom: 12px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        table.data th,
        table.data td {
            border: 1px solid #333;
            padding: 4px 5px;
            font-size: 10px;
        }

        table.data th {
            background-color: #e5e5e5;
            text-align: center;
        }

        table.data td.center {
            text-align: center;
        }

        .ttd-wrapper {
            width: 100%;
            margin-top: 30px;
        }

        .ttd-box {
            width: 260px;
            float: right;
            text-align: center;
        }

        .ttd-box .tempat-tanggal {
            margin-bottom: 4px;
        }

        .ttd-box .jabatan {
            margin-bottom: 70px;
        }

        .ttd-box .nama {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    <header>
        <table class="kop-table">
            <tr>
                <td class="kop-logo">
                    @if ($logoBase64)
                        <img src="{{ $logoBase64 }}" style="width:70px;">
                    @endif
                </td>
                <td class="kop-text">
                    <p class="instansi">{{ $pengaturan->nama_instansi }}</p>
                    @if ($pengaturan->alamat_instansi)
                        <p class="alamat">{{ $pengaturan->alamat_instansi }}</p>
                    @endif
                    @if ($pengaturan->telepon_instansi)
                        <p class="alamat">Telp. {{ $pengaturan->telepon_instansi }}</p>
                    @endif
                </td>
                <td class="kop-logo"></td>
            </tr>
        </table>
    </header>

    <footer>
        Dicetak melalui Sistem Informasi Administrasi Tahanan pada {{ now()->translatedFormat('d F Y H:i') }}
    </footer>

    <h1 class="title">Laporan Data Tahanan</h1>

    @if ($filterLabel)
        <p class="filter-info">{{ $filterLabel }}</p>
    @endif

    <table class="data">
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Registrasi</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $record)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $record->nomor_registrasi }}</td>
                    <td>{{ $record->nik }}</td>
                    <td>{{ $record->nama }}</td>
                    <td class="center">{{ optional($record->tanggal_masuk)->format('d-m-Y') }}</td>
                    <td class="center">{{ optional($record->tanggal_keluar)->format('d-m-Y') }}</td>
                    <td class="center">{{ ucfirst($record->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td class="center" colspan="7">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-wrapper">
        <div class="ttd-box">
            <p class="tempat-tanggal">{{ $tempatTandaTangan }}, {{ now()->translatedFormat('d F Y') }}</p>
            <p class="jabatan">{{ $pengaturan->jabatan_penanggung_jawab ?: '(Jabatan Penanggung Jawab)' }}</p>
            <p class="nama">{{ $pengaturan->nama_penanggung_jawab ?: '(Nama Penanggung Jawab)' }}</p>
            <p class="nrp">{{ $pengaturan->pangkat_nrp_penanggung_jawab ? 'NRP/Pangkat ' . $pengaturan->pangkat_nrp_penanggung_jawab : '' }}</p>
        </div>
    </div>

</body>
</html>
