<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap & FontAwesome (Same as your public pages) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --brand: #be212a;
            --brand-dark: #9a1a22;
            --slate: #1e293b;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #1f2937;
        }

        .error-container {
            text-align: center;
            padding: 40px 20px;
            max-width: 600px;
        }

        .error-code {
            font-size: 8rem;
            font-weight: 800;
            line-height: 1;
            color: var(--slate);
            margin-bottom: 10px;
            letter-spacing: -4px;
            text-shadow: 4px 4px 0px rgba(190, 33, 42, 0.15);
        }

        .error-code span {
            color: var(--brand);
        }

        .error-icon {
            font-size: 3rem;
            color: var(--brand);
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        h2 {
            font-weight: 800;
            color: var(--slate);
            margin-bottom: 15px;
        }

        p {
            font-size: 1.1rem;
            color: #64748b;
            margin-bottom: 30px;
        }

        .btn-brand {
            background-color: var(--brand);
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(190, 33, 42, 0.3);
        }

        .btn-brand:hover {
            background-color: var(--brand-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(190, 33, 42, 0.4);
        }

        .btn-outline-slate {
            border: 2px solid #cbd5e1;
            color: #475569;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 30px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-slate:hover {
            background-color: #f8fafc;
            border-color: var(--slate);
            color: var(--slate);
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-20px);
            }

            60% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body>

    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-baseball-ball"></i>
        </div>

        <div class="error-code">
            4<span>0</span>4
        </div>

        <h2>Out of the Park!</h2>
        <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>

        <div class="d-flex justify-content-center" style="gap: 15px;">
            <a href="{{ url('/') }}" class="btn btn-brand">
                <i class="fas fa-home mr-2"></i> Back to Home
            </a>
            <a href="javascript:history.back()" class="btn btn-outline-slate">
                <i class="fas fa-arrow-left mr-2"></i> Go Back
            </a>
        </div>
    </div>

</body>

</html>
