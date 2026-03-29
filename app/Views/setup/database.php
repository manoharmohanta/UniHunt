<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Setup - UniSearch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Step 1: Database Configuration</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <form action="<?= base_url('setup/database_save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="hostname" class="form-label">Database Hostname</label>
                                <input type="text" class="form-control" id="hostname" name="hostname" value="localhost"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="database" class="form-label">Database Name</label>
                                <input type="text" class="form-control" id="database" name="database" value="unihunt"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Database Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="root"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Database Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">Save & Continue</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>