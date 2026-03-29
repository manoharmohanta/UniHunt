<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Setup - UniSearch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Step 2: Admin Account Setup</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                        <?php endif; ?>

                        <div class="alert alert-info">
                            Your database connection is successful! Now, set up your initial admin account. This process
                            will also run all required database migrations and seeders automatically.
                        </div>

                        <form action="<?= base_url('setup/admin_save') ?>" method="POST">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="admin_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="admin_name" name="admin_name"
                                    placeholder="John Doe" required>
                            </div>
                            <div class="mb-3">
                                <label for="admin_email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="admin_email" name="admin_email"
                                    placeholder="admin@example.com" required>
                            </div>
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary" id="submitBtn">Install System</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('submitBtn').addEventListener('click', function () {
            if (document.getElementById('admin_name').value && document.getElementById('admin_email').value) {
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Installing...';
                this.classList.add('disabled');
            }
        });
    </script>
</body>

</html>