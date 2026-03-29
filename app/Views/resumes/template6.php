<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Academic Resume</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 40px; }
        .grid { display: grid; grid-template-columns: 250px 1fr; gap: 40px; }
        .left-col { border-right: 1px solid #eee; padding-right: 20px; }
        .name { font-size: 28px; font-weight: bold; margin-bottom: 5px; color: #000; }
        .title { font-size: 14px; color: #666; margin-bottom: 20px; }
        .contact-box { font-size: 12px; margin-bottom: 30px; }
        .contact-box div { margin-bottom: 5px; }
        .section-title { font-size: 13px; font-weight: bold; text-transform: uppercase; color: #0056b3; margin-bottom: 15px; border-bottom: 1px solid #0056b3; pb-1; }
        .skill-list { list-style: none; padding: 0; font-size: 12px; }
        .skill-list li { margin-bottom: 5px; }
        .main-section { margin-bottom: 30px; }
        .main-item { margin-bottom: 20px; }
        .main-item-header { display: flex; justify-content: space-between; font-weight: bold; }
        .main-item-sub { font-style: italic; color: #555; font-size: 13px; margin-bottom: 8px; }
        ul { padding-left: 20px; margin: 0; }
        li { font-size: 13px; margin-bottom: 3px; }
    </style>
</head>
<body>
    <div class="grid">
        <div class="left-col">
            <div class="name"><?= $name ?? 'Your Name' ?></div>
            <div class="title"><?= $title ?? 'Academic Scholar' ?></div>
            
            <div class="contact-box">
                <div class="section-title">Contact</div>
                <div><?= $email ?? 'email@example.com' ?></div>
                <div><?= $phone ?? '123-456-7890' ?></div>
                <div><?= $location ?? 'City, State' ?></div>
            </div>

            <div class="section-title">Skills</div>
            <ul class="skill-list">
                <?php foreach($skills as $skill): ?>
                <li><?= $skill ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="right-col">
            <div class="main-section">
                <div class="section-title">Professional Summary</div>
                <p style="font-size: 13px;"><?= $summary ?? 'Summary...' ?></p>
            </div>
            
            <div class="main-section">
                <div class="section-title">Experience</div>
                <?php foreach($experience as $exp): ?>
                <div class="main-item">
                    <div class="main-item-header">
                        <span><?= $exp['company'] ?></span>
                        <span><?= $exp['dates'] ?></span>
                    </div>
                    <div class="main-item-sub"><?= $exp['title'] ?></div>
                    <ul>
                        <?php foreach($exp['highlights'] as $hl): ?>
                        <li><?= $hl ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="main-section">
                <div class="section-title">Education</div>
                <?php foreach($education as $edu): ?>
                <div class="main-item">
                    <div class="main-item-header">
                        <span><?= $edu['school'] ?></span>
                        <span><?= $edu['dates'] ?></span>
                    </div>
                    <div class="main-item-sub"><?= $edu['degree'] ?> | GPA: <?= $edu['gpa'] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
