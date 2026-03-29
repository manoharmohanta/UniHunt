<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $subject ?? 'UniHunt Notification' ?>
    </title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #0b1220;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #012169;
            padding: 30px 20px;
            text-align: center;
        }

        .logo-text {
            color: #ffffff;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-decoration: none;
        }

        .logo-uni {
            color: #c91331;
        }

        .content {
            padding: 40px;
            text-align: left;
            line-height: 1.6;
            color: #334155;
            min-height: 200px;
        }

        /* Typography */
        h1,
        h2,
        h3 {
            color: #0f172a;
            margin-top: 0;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 20px;
            margin-bottom: 16px;
        }

        p {
            margin-bottom: 16px;
            font-size: 16px;
        }

        ul,
        ol {
            margin-bottom: 20px;
            padding-left: 20px;
        }

        li {
            margin-bottom: 8px;
        }

        /* Links & Buttons */
        a {
            color: #012169;
            text-decoration: underline;
            font-weight: 600;
        }

        .btn {
            display: inline-block;
            background-color: #c91331;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }

        .btn:hover {
            background-color: #b00f2a;
        }

        .footer {
            background: #f1f5f9;
            padding: 30px 20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
        }

        .footer-links {
            margin-bottom: 16px;
        }

        .footer-links a {
            color: #64748b;
            margin: 0 8px;
            text-decoration: none;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: #012169;
        }

        .address {
            color: #94a3b8;
            font-style: normal;
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <a href="<?= base_url() ?>" class="logo-text">
                <span class="logo-uni">UNI</span>HUNT
            </a>
        </div>

        <!-- Main Content -->
        <div class="content">
            <?= $this->renderSection('content') ?>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-links">
                <a href="<?= base_url('privacy') ?>">Privacy Policy</a>
                <a href="<?= base_url('contact') ?>">Contact Support</a>
                <a href="#">Unsubscribe</a>
            </div>
            <div class="address">
                &copy;
                <?= date('Y') ?> UniHunt Inc.<br>
                123 Education Square, London, UK
            </div>
        </div>
    </div>
</body>

</html>