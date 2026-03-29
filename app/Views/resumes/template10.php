<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minimalist Academic CV</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Crimson+Pro:wght@400;600;700&display=swap');
        
        body { 
            font-family: 'Crimson Pro', serif; 
            color: #111; 
            line-height: 1.4; 
            margin: 0; 
            padding: 0;
            background: #fff;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 60px 50px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        .name {
            font-size: 28px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 5px;
        }

        .contact-info {
            font-size: 14px;
            font-style: italic;
            color: #444;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-bottom: 1px solid #111;
            padding-bottom: 3px;
            margin-bottom: 15px;
        }

        .entry {
            margin-bottom: 15px;
        }

        .entry-header {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            font-size: 15px;
        }

        .entry-sub {
            font-style: italic;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .entry-content {
            font-size: 14px;
            padding-left: 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 3px;
            position: relative;
            padding-left: 15px;
        }

        li::before {
            content: "-";
            position: absolute;
            left: 0;
        }

        .skills-entry {
            font-size: 14px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .skill-item {
            font-weight: 600;
        }

        .skill-item::after {
            content: " •";
        }

        .skill-item:last-child::after {
            content: "";
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1 class="name"><?= $name ?? 'Your Name' ?></h1>
            <div class="contact-info">
                <?= $email ?? 'email@example.com' ?> | <?= $phone ?? '123-456-7890' ?> | <?= $location ?? 'Location' ?>
                <?php if(!empty($linkedin)): ?>
                <br>LinkedIn: <?= $linkedin ?>
                <?php endif; ?>
            </div>
        </header>

        <section class="section">
            <h2 class="section-title">Professional Summary</h2>
            <div class="entry-content"><?= $summary ?? 'Summary content...' ?></div>
        </section>

        <section class="section">
            <h2 class="section-title">Education</h2>
            <?php foreach($education as $edu): ?>
            <div class="entry">
                <div class="entry-header">
                    <span><?= $edu['degree'] ?></span>
                    <span><?= $edu['dates'] ?></span>
                </div>
                <div class="entry-sub"><?= $edu['school'] ?></div>
                <?php if(!empty($edu['gpa'])): ?>
                <div class="entry-content">GPA: <?= $edu['gpa'] ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </section>

        <section class="section">
            <h2 class="section-title">Experience</h2>
            <?php foreach($experience as $exp): ?>
            <div class="entry">
                <div class="entry-header">
                    <span><?= $exp['title'] ?></span>
                    <span><?= $exp['dates'] ?></span>
                </div>
                <div class="entry-sub"><?= $exp['company'] ?>, <?= $exp['location'] ?></div>
                <ul class="entry-content">
                    <?php if(!empty($exp['highlights'])): ?>
                        <?php foreach($exp['highlights'] as $hl): ?>
                        <li><?= $hl ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </section>

        <section class="section">
            <h2 class="section-title">Technical Skills</h2>
            <div class="skills-entry">
                <?php foreach($skills as $skill): ?>
                <span class="skill-item"><?= $skill ?></span>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>
