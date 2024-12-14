<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* Body and Background */
        body {
            background-color: #121212;
            color: #ffffff;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            font-family: 'Arial', sans-serif;
            position: relative;
        }

        /* Animated Background Glow */
        .glow {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(13, 110, 253, 0.6), transparent);
            border-radius: 50%;
            filter: blur(100px);
            animation: moveGlow 10s infinite alternate;
        }

        .glow.one {
            top: 10%;
            left: 20%;
        }

        .glow.two {
            bottom: 10%;
            right: 20%;
            animation-delay: 3s;
        }

        @keyframes moveGlow {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(50px);
            }
        }

        /* Centered Content */
        .error-container {
            text-align: center;
            z-index: 2;
        }

        .error-container h1 {
            font-size: 8rem;
            font-weight: bold;
            color: #0d6efd;
            text-shadow: 0 0 20px rgba(13, 110, 253, 0.7);
            margin-bottom: 20px;
        }

        .error-container p {
            font-size: 1.5rem;
            margin-bottom: 30px;
        }

        /* Button */
        .btn-back {
            font-size: 1.1rem;
            font-weight: 600;
            background-color: #0d6efd;
            color: #ffffff;
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
            text-decoration: none;
            box-shadow: 0 0 15px rgba(13, 110, 253, 0.5);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .btn-back:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(13, 110, 253, 0.8);
            background-color: #0056b3;
            color: #fff;
        }

        /* Icon Animation */
        .icon-404 {
            font-size: 5rem;
            color: #ffc107;
            margin-bottom: 20px;
            animation: spin 2s infinite linear;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Glowing Background Effects -->
    <div class="glow one"></div>
    <div class="glow two"></div>

    <!-- Error Content -->
    <div class="error-container">
        <!-- Icon -->
        <i class="bi bi-emoji-frown icon-404"></i>
        <!-- 404 Title -->
        <h1>404</h1>
        <!-- Message -->
        <p>Oops! The page you are looking for doesn’t exist.</p>
        <!-- Go Back Button -->
        <a href="/" class="btn btn-back">
            <i class="bi bi-arrow-left"></i> Go Back Home
        </a>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
