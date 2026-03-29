<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tech Resume</title>
    <style>
        body { font-family: 'JetBrains Mono', monospace; background: #0f172a; color: #e2e8f0; margin: 0; padding: 40px; line-height: 1.6; }
        .container { max-width: 900px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: flex-end; border-bottom: 1px solid #334155; padding-bottom: 20px; margin-bottom: 30px; }
        .name { font-size: 32px; font-weight: 800; color: #38bdf8; }
        .contact { font-size: 12px; text-align: right; color: #94a3b8; }
        .section { margin-bottom: 30px; }
        .section-title { font-size: 14px; font-weight: 700; color: #38bdf8; text-transform: uppercase; margin-bottom: 15px; display: flex; align-items: center; }
        .section-title::before { content: '>'; margin-right: 10px; color: #7dd3fc; }
        .card { background: #1e293b; border-radius: 8px; padding: 20px; border: 1px solid #334155; margin-bottom: 15px; }
        .card-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .company { font-weight: 700; color: #f1f5f9; font-size: 16px; }
        .date { color: #64748b; font-size: 12px; }
        .role { color: #7dd3fc; font-size: 14px; margin-bottom: 10px; }
        ul { padding-left: 20px; margin: 0; }
        li { margin-bottom: 5px; font-size: 13px; color: #cbd5e1; }
        .skill-group { display: flex; flex-wrap: wrap; gap: 8px; }
        .skill { background: #0ea5e920; color: #38bdf8; border: 1px solid #38bdf840; padding: 2px 10px; border-radius: 4px; font-size: 12px; }
        a { color: #38bdf8; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <div class="name"><?= $name ?? 'Your Name' ?></div>
                <div style="color: #94a3b8;"><?= $title ?? 'Full Stack Developer' ?></div>
            </div>
            <div class="contact">
                <div><?= $email ?? 'email@example.com' ?></div>
                <div><?= $phone ?? '123-456-7890' ?></div>
                <div><?= $location ?? 'Remote / City' ?></div>
                <?php if(!empty($linkedin)): ?><div><a href="#"><?= $linkedin ?></a></div><?php endif; ?>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Professional Summary</div>
            <p style="font-size: 14px; color: #cbd5e1;"><?= $summary ?? 'Tech-focused summary...' ?></p>
        </div>

        <div class="section">
            <div class="section-title">Stack & Skills</div>
            <div class="skill-group">
                <?php foreach($skills as $skill): ?>
                <span class="skill"><?= $skill ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Experience</div>
            <?php foreach($experience as $exp): ?>
            <div class="card">
                <div class="card-header">
                    <span class="company"><?= $exp['company'] ?></span>
                    <span class="date"><?= $exp['dates'] ?></span>
                </div>
                <div class="role"><?= $exp['title'] ?></div>
                <ul>
                    <?php foreach($exp['highlights'] as $hl): ?>
                    <li><?= $hl ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="section">
            <div class="section-title">Education</div>
            <?php foreach($education as $edu): ?>
            <div class="card" style="padding: 15px;">
                <div class="card-header">
                    <span class="company" style="font-size: 14px;"><?= $edu['school'] ?></span>
                    <span class="date"><?= $edu['dates'] ?></span>
                </div>
                <div style="font-size: 13px; color: #7dd3fc;"><?= $edu['degree'] ?></div>
                <div style="font-size: 12px; color: #64748b;">GPA: <?= $edu['gpa'] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
