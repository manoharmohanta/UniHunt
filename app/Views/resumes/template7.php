<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modern Resume</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 40px; line-height: 1.6; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #1a365d; padding-bottom: 20px; margin-bottom: 30px; }
        .name-box h1 { margin: 0; font-size: 32px; color: #1a365d; text-transform: uppercase; letter-spacing: 1px; }
        .name-box p { margin: 5px 0 0; font-size: 18px; color: #4a5568; }
        .contact-info { text-align: right; font-size: 13px; color: #4a5568; }
        .main-grid { display: grid; grid-template-columns: 1fr; gap: 30px; }
        .section { margin-bottom: 10px; }
        .section-title { font-size: 16px; font-weight: bold; color: #1a365d; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-bottom: 15px; }
        .item { margin-bottom: 20px; }
        .item-header { display: flex; justify-content: space-between; font-weight: bold; font-size: 15px; color: #2d3748; }
        .item-sub { display: flex; justify-content: space-between; font-style: italic; color: #718096; font-size: 13px; margin-bottom: 8px; }
        ul { padding-left: 20px; margin: 0; }
        li { font-size: 14px; color: #4a5568; margin-bottom: 5px; }
        .skills-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
        .skill-item { background: #f7fafc; padding: 5px 10px; border-radius: 4px; font-size: 12px; border: 1px solid #edf2f7; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="name-box">
            <h1><?= $name ?? 'Your Name' ?></h1>
            <p><?= $title ?? 'Professional Title' ?></p>
        </div>
        <div class="contact-info">
            <div><?= $email ?? 'email@example.com' ?></div>
            <div><?= $phone ?? '123-456-7890' ?></div>
            <div><?= $location ?? 'City, State' ?></div>
            <?php if(!empty($linkedin)): ?><div><?= $linkedin ?></div><?php endif; ?>
        </div>
    </div>

    <div class="main-grid">
        <div class="section">
            <div class="section-title">Professional Summary</div>
            <p style="font-size: 14px; margin: 0;"><?= $summary ?? 'Your professional summary...' ?></p>
        </div>

        <div class="section">
            <div class="section-title">Experience</div>
            <?php foreach($experience as $exp): ?>
            <div class="item">
                <div class="item-header">
                    <span><?= $exp['title'] ?></span>
                    <span><?= $exp['dates'] ?></span>
                </div>
                <div class="item-sub">
                    <span><?= $exp['company'] ?></span>
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
                    <span><?= $edu['degree'] ?></span>
                    <span><?= $edu['dates'] ?></span>
                </div>
                <div class="item-sub">
                    <span><?= $edu['school'] ?></span>
                    <span>GPA: <?= $edu['gpa'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="section">
            <div class="section-title">Skills</div>
            <div class="skills-grid">
                <?php foreach($skills as $skill): ?>
                <span class="skill-item"><?= $skill ?></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
