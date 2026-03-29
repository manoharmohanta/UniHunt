<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elegant Resume</title>
    <style>
        body { font-family: 'Garamond', serif; color: #1a1a1a; margin: 0; padding: 60px; line-height: 1.4; }
        .name { font-size: 32px; font-weight: normal; text-align: center; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 5px; }
        .subtitle { text-align: center; font-style: italic; color: #666; font-size: 16px; margin-bottom: 20px; }
        .contact { text-align: center; font-size: 13px; border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 10px 0; margin-bottom: 40px; }
        .section { margin-bottom: 30px; }
        .section-title { font-size: 16px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px; border-bottom: 1px solid #333; display: inline-block; }
        .item { margin-bottom: 20px; }
        .item-header { display: flex; justify-content: space-between; font-weight: bold; font-size: 15px; }
        .item-sub { display: flex; justify-content: space-between; font-style: italic; color: #444; margin-bottom: 8px; }
        ul { padding-left: 20px; }
        li { margin-bottom: 4px; font-size: 14px; }
        .skills-text { font-size: 14px; text-align: justify; }
    </style>
</head>
<body>
    <div class="name"><?= $name ?? 'Your Name' ?></div>
    <div class="subtitle"><?= $title ?? 'Professional Title' ?></div>
    <div class="contact">
        <?= $location ?? 'Location' ?> &bull; <?= $phone ?? 'Phone' ?> &bull; <?= $email ?? 'Email' ?>
    </div>

    <div class="section">
        <div class="section-title">Professional Summary</div>
        <p style="font-size: 14px;"><?= $summary ?? 'Summary content...' ?></p>
    </div>

    <div class="section">
        <div class="section-title">Experience</div>
        <?php foreach($experience as $exp): ?>
        <div class="item">
            <div class="item-header">
                <span><?= $exp['company'] ?></span>
                <span><?= $exp['dates'] ?></span>
            </div>
            <div class="item-sub">
                <span><?= $exp['title'] ?></span>
                <span><?= $exp['location'] ?></span>
            </div>
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
        <div class="item">
            <div class="item-header">
                <span><?= $edu['school'] ?></span>
                <span><?= $edu['dates'] ?></span>
            </div>
            <div class="item-sub">
                <span><?= $edu['degree'] ?></span>
                <span>GPA: <?= $edu['gpa'] ?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="section">
        <div class="section-title">Skills & Expertise</div>
        <div class="skills-text">
            <?= implode(', ', $skills) ?>
        </div>
    </div>
</body>
</html>
