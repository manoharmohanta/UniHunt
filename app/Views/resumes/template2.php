<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modern Resume</title>
    <style>
        body { font-family: 'Inter', sans-serif; color: #2d3748; line-height: 1.6; margin: 0; display: flex; min-height: 100vh; }
        .sidebar { width: 30%; background: #1a202c; color: white; padding: 40px 20px; }
        .main-content { width: 70%; padding: 40px; }
        .sidebar h1 { font-size: 24px; margin: 0; color: #63b3ed; }
        .sidebar .contact-info { margin-top: 30px; font-size: 13px; }
        .contact-info div { margin-bottom: 10px; display: flex; align-items: center; gap: 8px; }
        .section-title { font-size: 16px; font-weight: 700; color: #2c5282; text-transform: uppercase; letter-spacing: 1px; margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #ebf8ff; pb-1; }
        .sidebar .section-title { color: #63b3ed; border-bottom-color: #2d3748; }
        .item { margin-bottom: 20px; }
        .item-title { font-weight: 700; font-size: 16px; color: #1a202c; }
        .item-subtitle { color: #4a5568; font-weight: 600; font-size: 14px; }
        .item-meta { color: #718096; font-size: 12px; margin-bottom: 8px; }
        ul { padding-left: 18px; margin-top: 5px; }
        li { margin-bottom: 5px; font-size: 14px; }
        .skill-tag { display: inline-block; background: #2d3748; color: #e2e8f0; padding: 4px 10px; border-radius: 12px; font-size: 11px; margin: 3px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h1><?= $name ?? 'Your Name' ?></h1>
        <p style="font-size: 14px; color: #a0aec0;"><?= $title ?? 'Professional Title' ?></p>
        
        <div class="contact-info">
            <div class="section-title">Contact</div>
            <div><?= $email ?? 'email@example.com' ?></div>
            <div><?= $phone ?? '123-456-7890' ?></div>
            <div><?= $location ?? 'City, State' ?></div>
            <?php if(!empty($linkedin)): ?><div><?= $linkedin ?></div><?php endif; ?>
        </div>

        <div class="section-title">Skills</div>
        <div style="margin-top: 10px;">
            <?php foreach($skills as $skill): ?>
            <span class="skill-tag"><?= $skill ?></span>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="main-content">
        <div class="section-title" style="margin-top: 0;">Summary</div>
        <p style="font-size: 14px;"><?= $summary ?? 'Professional summary goes here...' ?></p>

        <div class="section-title">Experience</div>
        <?php foreach($experience as $exp): ?>
        <div class="item">
            <div class="item-title"><?= $exp['title'] ?></div>
            <div class="item-subtitle"><?= $exp['company'] ?></div>
            <div class="item-meta"><?= $exp['dates'] ?> | <?= $exp['location'] ?></div>
            <ul>
                <?php foreach($exp['highlights'] as $hl): ?>
                <li><?= $hl ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endforeach; ?>

        <div class="section-title">Education</div>
        <?php foreach($education as $edu): ?>
        <div class="item">
            <div class="item-title"><?= $edu['degree'] ?></div>
            <div class="item-subtitle"><?= $edu['school'] ?></div>
            <div class="item-meta"><?= $edu['dates'] ?> | GPA: <?= $edu['gpa'] ?></div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
