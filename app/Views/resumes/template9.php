<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creative Sidebar Resume</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');
        
        body { 
            font-family: 'Outfit', sans-serif; 
            color: #2c3e50; 
            line-height: 1.5; 
            margin: 0; 
            padding: 0;
            background: #fdfdfd;
        }

        .resume-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: #4f46e5;
            color: #fff;
            padding: 50px 30px;
            display: flex;
            flex-col;
            gap: 40px;
        }

        .main-content {
            flex: 1;
            padding: 60px 40px;
            background: #fff;
        }

        .profile-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .initials-circle {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            margin: 0 auto 15px;
            border: 2px solid rgba(255,255,255,0.4);
        }

        .sidebar-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            color: rgba(255,255,255,0.7);
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 10px;
        }

        .contact-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .contact-list li {
            font-size: 13px;
            margin-bottom: 15px;
            word-break: break-all;
        }

        .sidebar-skill {
            background: rgba(255,255,255,0.1);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-bottom: 8px;
            display: inline-block;
            margin-right: 5px;
        }

        .name-banner {
            margin-bottom: 40px;
        }

        .name-banner h1 {
            font-size: 42px;
            font-weight: 700;
            color: #111827;
            margin: 0;
            line-height: 1.1;
        }

        .name-banner h2 {
            font-size: 20px;
            font-weight: 400;
            color: #4f46e5;
            margin-top: 5px;
        }

        .section-box {
            margin-bottom: 40px;
        }

        .section-label {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .exp-item {
            margin-bottom: 25px;
        }

        .exp-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .exp-role {
            font-weight: 700;
            font-size: 16px;
            color: #111827;
        }

        .exp-company {
            font-size: 14px;
            color: #4f46e5;
            font-weight: 600;
        }

        .exp-date {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
        }

        .exp-highlights {
            margin-top: 10px;
            padding-left: 15px;
        }

        .exp-highlights li {
            font-size: 13px;
            color: #4b5563;
            margin-bottom: 5px;
        }

        @media print {
            .sidebar { background: #4f46e5 !important; -webkit-print-color-adjust: exact; }
            .initials-circle { border: 2px solid #fff !important; }
        }
    </style>
</head>
<body>
    <div class="resume-wrapper">
        <aside class="sidebar">
            <div class="profile-container">
                <?php 
                    $initials = '';
                    if(!empty($name)) {
                        $parts = explode(' ', $name);
                        foreach($parts as $p) $initials .= strtoupper(substr($p, 0, 1));
                    }
                ?>
                <div class="initials-circle"><?= substr($initials, 0, 2) ?></div>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Contact</h3>
                <ul class="contact-list">
                    <li><?= $email ?? 'email@example.com' ?></li>
                    <li><?= $phone ?? '123-456-7890' ?></li>
                    <li><?= $location ?? 'City, State' ?></li>
                    <?php if(!empty($linkedin)): ?>
                    <li><?= $linkedin ?></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Skills</h3>
                <?php foreach($skills as $skill): ?>
                <span class="sidebar-skill"><?= $skill ?></span>
                <?php endforeach; ?>
            </div>
        </aside>

        <main class="main-content">
            <div class="name-banner">
                <h1><?= $name ?? 'Your Name' ?></h1>
                <h2><?= $title ?? 'Job Title' ?></h2>
            </div>

            <div class="section-box">
                <h3 class="section-label">Summary</h3>
                <p style="font-size: 14px; color: #4b5563;"><?= $summary ?? 'Professional summary...' ?></p>
            </div>

            <div class="section-box">
                <h3 class="section-label">Experience</h3>
                <?php foreach($experience as $exp): ?>
                <div class="exp-item">
                    <div class="exp-header">
                        <div class="exp-role"><?= $exp['title'] ?></div>
                        <div class="exp-date"><?= $exp['dates'] ?></div>
                    </div>
                    <div class="exp-company"><?= $exp['company'] ?> | <?= $exp['location'] ?></div>
                    <ul class="exp-highlights">
                        <?php if(!empty($exp['highlights'])): ?>
                            <?php foreach($exp['highlights'] as $hl): ?>
                            <li><?= $hl ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="section-box">
                <h3 class="section-label">Education</h3>
                <?php foreach($education as $edu): ?>
                <div class="exp-item">
                    <div class="exp-header">
                        <div class="exp-role"><?= $edu['degree'] ?></div>
                        <div class="exp-date"><?= $edu['dates'] ?></div>
                    </div>
                    <div class="exp-company"><?= $edu['school'] ?></div>
                    <?php if(!empty($edu['gpa'])): ?>
                    <p style="font-size: 13px; margin-top: 5px;">CGPA: <?= $edu['gpa'] ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</body>
</html>
