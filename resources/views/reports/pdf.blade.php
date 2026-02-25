<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Produksi & QC</title>

    <style>
        /* === STYLE TETAP PUNYA KODE 1 === */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
            padding: 20px;
            background: #fff;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 25px;
            margin-bottom: 25px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 22pt;
            font-weight: bold;
            color: black;
            margin-bottom: 8px;
        }

        .header .subtitle {
            font-size: 10pt;
            color: black;
            opacity: 0.9;
        }

        .period-info {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #2a5298;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .period-info p {
            margin: 3px 0;
            font-size: 9pt;
        }

        .section-title {
            font-size: 13pt;
            font-weight: bold;
            color: #2a5298;
            margin: 20px 0 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #e0e0e0;
        }

        .analysis-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .analysis-box {
            padding: 15px;
            background: #fafafa;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }

        .analysis-box h3 {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 12px;
            color: #2a5298;
            padding-bottom: 5px;
            border-bottom: 1px dashed #ccc;
        }

        .analysis-item {
            background: white;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 6px;
            border-left: 3px solid #2a5298;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .analysis-item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .analysis-item-title {
            font-size: 10pt;
            font-weight: bold;
        }

        .analysis-item-badge {
            max-width: max-content;
            background: #2a5298;
            color: white;
            padding: 3px 10px;
            margin-top: 2px;
            border-radius: 12px;
            font-size: 8pt;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9pt;
        }

        table thead {
            background: #2a5298;
            color: white;
        }

        table th {
            padding: 10px;
            text-align: left;
            font-weight: 600;
            font-size: 8pt;
        }

        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-completed {
            background: #c8e6c9;
            color: #388e3c;
        }

        .badge-lolos {
            background: #c8e6c9;
            color: #2e7d32;
        }

        .badge-partial {
            background: #fff3cd;
            color: #ef6c00;
        }

        .badge-gagal {
            background: #ffcdd2;
            color: #c62828;
        }

        .summary-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .footer {
            text-align: center;
            font-size: 8pt;
            color: #999;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <h1>LAPORAN PRODUKSI & QUALITY CONTROL</h1>
            <div class="subtitle">Pencatatan Proses Pemotongan Komponen Otomotif</div>
        </div>

        <!-- PERIOD INFO -->
        <div class="period-info">
            <div>
                <p><strong>Periode Laporan:</strong>
                    {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
                </p>

                <p><strong>Digenerate pada:</strong> {{ $generatedAt }}</p>
            </div>
            <div>
                <p><strong>Digenerate oleh:</strong> {{ $generatedBy }}</p>
                <p><strong>Status:</strong> Final</p>
            </div>
        </div>

        <!-- ANALISIS PRODUKSI -->
        <h2 class="section-title">ANALISIS PRODUKSI</h2>

        <div class="analysis-container">

            <!-- PER PART -->
            <div class="analysis-box">
                <h3>Analisis per Part</h3>

                @foreach ($partAnalysis->take(5) as $item)
                    <div class="analysis-item">
                        <div class="analysis-item-header">
                            <div class="analysis-item-title">{{ $item['part_name'] }}</div>
                            <div class="analysis-item-badge">{{ $item['total_quantity'] }} pcs</div>
                        </div>
                        <div class="analysis-item-code">Kode: {{ $item['part_code'] }}</div>
                        <div class="analysis-item-stats">
                            Produksi: {{ $item['total_productions'] }} kali |
                            Lolos: {{ $item['lolos'] }} |
                            Partial: {{ $item['partial'] }} |
                            Gagal: {{ $item['gagal'] }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- PER OPERATOR -->
            <div class="analysis-box">
                <h3>Analisis per Operator</h3>

                @foreach ($operatorAnalysis->take(5) as $item)
                    <div class="analysis-item">
                        <div class="analysis-item-header">
                            <div class="analysis-item-title">{{ $item['operator_name'] }}</div>
                            <div class="analysis-item-badge">{{ $item['total_productions'] }} produksi</div>
                        </div>
                        <div class="analysis-item-code">Kode: {{ $item['operator_code'] }}</div>
                        <div class="analysis-item-stats">
                            Quantity: {{ $item['total_quantity'] }} pcs |
                            Lolos: {{ $item['lolos'] }} |
                            Partial: {{ $item['partial'] }} |
                            Gagal: {{ $item['gagal'] }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- DETAIL PRODUKSI -->
        <h2 class="section-title">DETAIL LAPORAN PRODUKSI</h2>

        <table>
            <thead>
                <tr>
                    <th>Tanggal Produksi</th>
                    <th>Part</th>
                    <th>Operator</th>
                    <th style="text-align: right;">Quantity</th>
                    <th>Status</th>
                    <th>QC</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productionReport as $production)
                    <tr>
                        <td>{{ $production->production_date->format('d/m/Y') }}</td>

                        <td>
                            <strong>{{ $production->part->name }}</strong><br>
                            <span style="font-size: 8pt; color: #888;">
                                {{ $production->part->code }}
                            </span>
                        </td>

                        <td>{{ $production->operator->name }}</td>

                        <td style="text-align: right; font-weight: bold;">
                            {{ $production->quantity }}
                        </td>

                        <td>
                            <span class="badge badge-completed">
                                {{ ucfirst($production->status) }}
                            </span>
                        </td>

                        <td>
                            @if ($production->qcInspection)
                                @if ($production->qcInspection->result === 'lolos')
                                    <span class="badge badge-lolos">LOLOS</span>
                                @elseif ($production->qcInspection->result === 'partial')
                                    <span class="badge badge-partial">PARTIAL</span>
                                @else
                                    <span class="badge badge-gagal">GAGAL</span>
                                @endif
                            @else
                                <span class="badge" style="background: #e0e0e0; color: #616161;">BELUM QC</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- RINGKASAN -->
        <div class="summary-info">
            <p><strong>RINGKASAN:</strong></p>
            <p>Total {{ $stats['total_productions'] }} produksi dengan quantity {{ $stats['total_quantity'] }} pcs.
            </p>
            <p>{{ $stats['total_lolos'] }} produksi lolos QC, {{ $stats['total_partial'] }} partial, dan {{ $stats['total_gagal'] }} gagal QC.</p>
            @if ($damageAnalysis->count() === 0)
                <p>Tidak ada kerusakan yang dilaporkan.</p>
            @endif
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>Laporan ini digenerate otomatis oleh Sistem Pencatatan Produksi</p>
            <p>© {{ date('Y') }} - Halaman 1</p>
        </div>

    </div>
</body>

</html>