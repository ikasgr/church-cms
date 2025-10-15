<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terjadi Kesalahan Sistem</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Poppins', Arial, sans-serif;
            background: radial-gradient(circle at top left, rgba(239, 68, 68, 0.16), transparent 55%),
                        linear-gradient(145deg, #fff5f5 0%, #fff 55%);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
        }
        .error-card {
            max-width: 640px;
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            padding: 3rem 2.75rem;
            box-shadow: 0 30px 60px rgba(220, 38, 38, 0.15);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .error-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at bottom right, rgba(248,113,113,0.18), transparent 55%);
            z-index: 0;
        }
        .error-card__inner {
            position: relative;
            z-index: 1;
        }
        .error-code {
            font-size: clamp(3rem, 9vw, 5.5rem);
            font-weight: 700;
            color: #ef4444;
            margin: 0 0 0.75rem;
        }
        h1 {
            font-size: clamp(1.75rem, 5vw, 2.4rem);
            margin: 0 0 1rem;
            font-weight: 600;
        }
        p {
            margin: 0 0 1.75rem;
            line-height: 1.7;
            color: #4b5563;
        }
        .steps {
            background: rgba(248, 113, 113, 0.1);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: left;
            margin-bottom: 2rem;
        }
        .steps ul {
            margin: 0;
            padding-left: 1.2rem;
        }
        .steps li {
            margin-bottom: 0.6rem;
            color: #374151;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }
        .actions a,
        .actions button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 160px;
            padding: 0.85rem 1.5rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            cursor: pointer;
        }
        .actions a.primary,
        .actions button.primary {
            background: #ef4444;
            color: #ffffff;
            box-shadow: 0 15px 30px rgba(239, 68, 68, 0.24);
        }
        .actions a.primary:hover,
        .actions button.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 36px rgba(239, 68, 68, 0.32);
        }
        .actions a.secondary {
            background: rgba(239, 68, 68, 0.12);
            color: #b91c1c;
        }
        .actions a.secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(239, 68, 68, 0.18);
        }
        .support {
            margin-top: 2.5rem;
            font-size: 0.85rem;
            color: #6b7280;
        }
        @media (max-width: 576px) {
            .error-card {
                padding: 2.5rem 1.75rem;
            }
            .steps {
                padding: 1.25rem;
            }
            .actions a,
            .actions button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="error-card">
        <div class="error-card__inner">
            <div class="error-code">500</div>
            <h1>Terjadi Kesalahan Sistem</h1>
            <p>
                Mohon maaf, sedang terjadi kendala pada sistem. Tim kami telah menerima laporan ini.
                Silakan coba beberapa langkah berikut sebelum menghubungi admin.
            </p>
            <div class="steps">
                <strong>Langkah yang dapat Anda coba:</strong>
                <ul>
                    <li>Periksa kembali koneksi internet Anda.</li>
                    <li>Muat ulang halaman setelah beberapa saat.</li>
                    <li>Jika mengisi formulir, pastikan semua data telah benar.</li>
                </ul>
            </div>
            <div class="actions">
                <button class="primary" type="button" onclick="window.location.reload()">Muat Ulang Halaman</button>
                <a class="secondary" href="<?= base_url() ?>">Kembali ke Beranda</a>
            </div>
            <div class="support">Jika masalah berlanjut, hubungi admin gereja melalui email atau WhatsApp yang tersedia.</div>
        </div>
    </main>
</body>
</html>
