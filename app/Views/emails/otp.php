<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your UniHunt Verification Code</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #0b1220;
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
            padding: 40px 20px;
            text-align: center;
        }
        .logo-text {
            color: #ffffff;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .logo-uni { color: #c91331; }
        .content {
            padding: 40px;
            text-align: center;
        }
        .greeting {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #0b1220;
        }
        .description {
            color: #5b6b8a;
            line-height: 1.6;
            margin-bottom: 32px;
        }
        .otp-container {
            background: #f0f4f8;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 32px;
        }
        .otp-code {
            font-size: 42px;
            font-weight: 800;
            letter-spacing: 8px;
            color: #012169;
            margin: 0;
        }
        .footer {
            background: #f1f5f9;
            padding: 24px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
        .security-note {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo-text">
                <span class="logo-uni">UNI</span>HUNT
            </div>
        </div>
        <div class="content">
            <h1 class="greeting">Verify your email</h1>
            <p class="description">
                Use the following verification code to complete your sign-in to UniHunt. This code will expire in 5 minutes.
            </p>
            <div class="otp-container">
                <h2 class="otp-code"><?= $otp ?></h2>
            </div>
            <p class="description">
                If you didn't request this code, you can safely ignore this email.
            </p>
        </div>
        <div class="footer">
            <p>&copy; 2026 UniHunt Inc. | Global Study Abroad Platform</p>
            <p>123 Education Square, London, UK</p>
            <div class="security-note">
                This is an automated message, please do not reply to this email.
            </div>
        </div>
    </div>
</body>
</html>
