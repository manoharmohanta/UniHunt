<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Creative Resume</title>
    <style>
        :root { --primary: #6366f1; --secondary: #4f46e5; }
        body { font-family: 'Outfit', sans-serif; color: #1f2937; margin: 0; padding: 0; background: #f9fafb; }
        .page { background: white; max-width: 800px; margin: 20px auto; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden; }
        .header { background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 50px 40px; }
        .name { font-size: 36px; font-weight: 800; margin: 0; letter-spacing: -1px; }
        .title { font-size: 18px; opacity: 0.9; font-weight: 500; }
        .grid { display: grid; grid-template-columns: 1fr 2fr; gap: 40px; padding: 40px; }
        .section-title { font-size: 14px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; display: flex; align-items: center; }
        .section-title::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; margin-left: 15px; }
        .contact-item { margin-bottom: 15px; font-size: 14px; }
        .contact-label { font-weight: 700; display: block; color: #6b7280; font-size: 11px; text-transform: uppercase; }
        .exp-item { margin-bottom: 30px; }
        .exp-header { display: flex; justify-content: space-between; align-items: baseline; }
        .exp-company { font-weight: 700; font-size: 18px; color: #111827; }
        .exp-date { font-size: 13px; color: #6b7280; font-weight: 500; }
        .exp-title { font-weight: 600; color: var(--primary); margin-bottom: 8px; }
        .edu-item { margin-bottom: 20px; }
        .skill-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .skill-dot { display: flex; justify-content: space-between; align-items: center; font-size: 13px; }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <h1 class="name"><?= $name ?? 'Your Name' ?></h1>
            <div class="title"><?= $title ?? 'Professional Title' ?></div>
        </div>
        <div class="grid">
            <div class="left-col">
                <div class="section-title">Contact</div>
                <div class="contact-item">
                    <span class="contact-label">Email</span>
                    <?= $email ?? 'email@example.com' ?>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Phone</span>
                    <?= $phone ?? '123-456-7890' ?>
                </div>
                <div class="contact-item">
                    <span class="contact-label">Location</span>
                    <?= $location ?? 'City, State' ?>
                </div>

                <div class="section-title" style="margin-top: 40px;">Skills</div>
                <div class="skill-grid">
                    <?php foreach($skills as $skill): ?>
                    <div class="skill-dot"><?= $skill ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="right-col">
                <div class="section-title">Experience</div>
                <?php foreach($experience as $exp): ?>
                <div class="exp-item">
                    <div class="exp-header">
                        <div class="exp-company"><?= $exp['company'] ?></div>
                        <div class="exp-date"><?= $exp['dates'] ?></div>
                    </div>
                    <div class="exp-title"><?= $exp['title'] ?></div>
                    <ul style="padding-left: 20px; font-size: 14px; color: #4b5563;">
                        <?php foreach($exp['highlights'] as $hl): ?>
                        <li><?= $hl ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>

                <div class="section-title">Education</div>
                <?php foreach($education as $edu): ?>
                <div class="edu-item">
                    <div class="exp-company" style="font-size: 16px;"><?= $edu['school'] ?></div>
                    <div class="exp-title" style="color: #6b7280;"><?= $edu['degree'] ?></div>
                    <div class="exp-date"><?= $edu['dates'] ?> | GPA: <?= $edu['gpa'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
