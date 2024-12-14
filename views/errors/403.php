<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .error-container {
            max-width: 600px;
        }
        .error-image img {
            max-width: 100%;
            height: auto;
        }
        h1 {
            font-size: 4rem;
            color: #dc3545;
        }
        p {
            font-size: 1.25rem;
            color: #6c757d;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-image">
            <!-- Replace with your own image URL -->
            <img src="/assets/images/403.png" width="400" height="400" alt="403 Forbidden">
        </div>
        <h1>403 Forbidden</h1>
        <p>Sorry, you don't have permission to access this page.</p>
        <a href="/" class="btn btn-primary mt-3">Go Back to Home</a>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
