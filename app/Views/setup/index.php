<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install UniSearch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>UniSearch Installation</h4>
                    </div>
                    <div class="card-body p-5">
                        <h5 class="card-title text-center mb-4">Welcome to UniSearch Setup</h5>
                        <p class="card-text text-muted text-center mb-5">
                            This installer will help you configure your database and create your initial admin account.
                            Please ensure your database is created on your server before proceeding.
                        </p>
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('setup/database') ?>" class="btn btn-primary btn-lg">Start
                                Installation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>