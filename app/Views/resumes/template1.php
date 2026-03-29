<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Professional Resume</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #333; line-height: 1.5; margin: 0; padding: 40px; }
        .header { text-align: center; border-bottom: 2px solid #333; pb-2; margin-bottom: 20px; }
        .name { font-size: 28px; font-weight: bold; text-transform: uppercase; }
        .contact { font-size: 14px; margin-top: 5px; }
        .section-title { font-size: 18px; font-weight: bold; border-bottom: 1px solid #ccc; margin-top: 20px; margin-bottom: 10px; text-transform: uppercase; }
        .item { margin-bottom: 15px; }
        .item-header { display: flex; justify-content: space-between; font-weight: bold; }
        .item-sub { display: flex; justify-content: space-between; font-style: italic; margin-bottom: 5px; }
        ul { margin: 5px 0 0 20px; padding: 0; }
        li { margin-bottom: 3px; }
        .skills { display: flex; flex-wrap: wrap; gap: 10px; }
        .skill-item { background: #f0f0f0; padding: 2px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="name"><?= $name ?? 'Your Name' ?></div>
        <div class="contact">
            <?= $email ?? 'email@example.com' ?> | <?= $phone ?? '123-456-7890' ?> | <?= $location ?? 'City, State' ?>
            <?php if(!empty($linkedin)): ?> | LinkedIn: <?= $linkedin ?><?php endif; ?>
        </div>
    </div>

    <div class="section-title">Summary</div>
    <p><?= $summary ?? 'Professional summary goes here...' ?></p>

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

    <div class="section-title">Skills</div>
    <div class="skills">
        <?php foreach($skills as $skill): ?>
        <span class="skill-item"><?= $skill ?></span>
        <?php endforeach; ?>
    </div>
</body>
</html>
