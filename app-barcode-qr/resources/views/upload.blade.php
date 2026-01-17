<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Mandiri</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #f9fafb, #eef1f5);
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #333;
        }

        .card {
            border-radius: 18px;
            border: none;
            background-color: #ffffff;
        }

        .card-body {
            padding: 32px;
        }

        h4 {
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .subtitle {
            font-size: 14px;
            color: #777;
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 14px;
            color: #444;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px 14px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #28a745;
        }

        .form-check-label {
            font-size: 14px;
            color: #555;
        }

        .btn-main {
            background-color: #28a745;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            padding: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-main:hover {
            background-color: #218838;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(40, 167, 69, 0.25);
        }

        .alert {
            border-radius: 10px;
            font-size: 14px;
        }

        .footer-note {
            font-size: 12px;
            color: #888;
            margin-top: 16px;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="text-center">
                            Print Mandiri
                        </h4>
                        <p class="text-center subtitle">
                            Layanan cetak dokumen Fotokopi Potokopi Kita
                        </p>

                        <!-- ALERT SUCCESS -->
                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- ALERT ERROR -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- FORM -->
                        <form action="{{ route('print.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    File PDF
                                </label>
                                <input type="file" name="file" class="form-control" accept="application/pdf" required>
                                <small class="text-muted">
                                    Format PDF, ukuran maksimum 20 MB
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Jumlah Salinan
                                </label>
                                <input type="number" name="copies" class="form-control" value="1" min="1" max="50"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Mode Cetak
                                </label>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="print_mode" value="bw" checked>
                                    <label class="form-check-label">
                                        Hitam putih
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="print_mode" value="color">
                                    <label class="form-check-label">
                                        Berwarna
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-main w-100">
                                Kirim ke printer
                            </button>

                        </form>

                    </div>
                </div>

                <p class="text-center footer-note">
                    Dokumen akan diproses otomatis dan dihapus setelah pencetakan selesai
                </p>

            </div>
        </div>
    </div>

</body>

</html>