<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>500 - Server Error</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa, #e4e7eb);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .error-container {
            background: #fff;
            max-width: 520px;
            width: 100%;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .error-code {
            font-size: 72px;
            font-weight: 700;
            color: #e3342f;
            margin: 0;
        }

        .error-title {
            font-size: 22px;
            margin: 8px 0 16px;
            font-weight: 600;
        }

        .error-message {
            font-size: 15px;
            color: #666;
            margin-bottom: 24px;
        }

        .error-details {
            text-align: left;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px;
            font-size: 14px;
        }

        .error-details p {
            margin: 6px 0;
        }

        .error-details strong {
            color: #111;
        }

        .hint {
            margin-top: 12px;
            font-size: 13px;
            color: #6b7280;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 24px 0;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1 class="error-code">500</h1>
        <div class="error-title">Server Error</div>
        <p class="error-message">
            Terjadi kesalahan pada sistem. Silakan coba lagi nanti.
        </p>

        @php
            $error = \EdiPrasetyo\ErrorLogCapture\Support\ErrorContext::get();
        @endphp

        @if ($error)
            <div class="divider"></div>

            <div class="error-details">
                <p><strong>Error ID:</strong> {{ $error->id }}</p>
                <p><strong>Code:</strong> {{ $error->hash }}</p>
                <p class="hint">
                    Silakan kirimkan kode ini ke developer untuk penanganan lebih lanjut.
                </p>
            </div>
        @endif
    </div>
</body>

</html>
