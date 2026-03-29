<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modern Slate Resume</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        
        body { 
            font-family: 'Inter', sans-serif; 
            color: #1e293b; 
            line-height: 1.6; 
            margin: 0; 
            padding: 0;
            background: #fff;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }

        .header { 
            background: #0f172a;
            color: #f8fafc;
            padding: 50px 40px;
            margin: -40px -40px 30px -40px;
        }

        .name { 
            font-size: 36px; 
            font-weight: 800; 
            letter-spacing: -0.025em;
            margin-bottom: 8px;
            color: #fff;
        }

        .title {
            font-size: 18px;
            font-weight: 600;
            color: #38bdf8;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .contact-grid { 
            display: grid;
            grid-template-cols: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            font-size: 13px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #cbd5e1;
        }

        .section-header { 
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 35px;
            margin-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 8px;
        }

        .section-title { 
            font-size: 16px; 
            font-weight: 800; 
            text-transform: uppercase; 
            letter-spacing: 0.1em;
            color: #0f172a;
        }

        .section-dot {
            width: 8px;
            height: 8px;
            background: #38bdf8;
            border-radius: 50%;
        }

        .summary {
            font-size: 14px;
            color: #475569;
        }

        .item { 
            margin-bottom: 25px; 
            position: relative;
        }

        .item-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: baseline;
            margin-bottom: 4px;
        }

        .item-title {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }

        .item-company {
            font-size: 14px;
            font-weight: 600;
            color: #38bdf8;
        }

        .item-date {
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            background: #f1f5f9;
            padding: 2px 10px;
            border-radius: 20px;
        }

        ul { 
            margin: 10px 0 0 0; 
            padding: 0; 
            list-style: none;
        }

        li { 
            font-size: 13px; 
            color: #475569;
            margin-bottom: 6px; 
            padding-left: 20px;
            position: relative;
        }

        li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #38bdf8;
            font-weight: bold;
        }

        .skills-container { 
            display: flex; 
            flex-wrap: wrap; 
            gap: 8px; 
            margin-top: 10px;
        }

        .skill-tag { 
            background: #f8fafc; 
            color: #334155; 
            border: 1px solid #e2e8f0;
            padding: 4px 12px; 
            border-radius: 6px; 
            font-size: 12px; 
            font-weight: 600;
        }

        @media print {
            body { padding: 0; }
            .container { padding: 40px; }
            .header { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 class="name"><?= $name ?? 'Your Name' ?></h1>
            <div class="title"><?= $title ?? 'Professional Title' ?></div>
            
            <div class="contact-grid">
                <div class="contact-item"><?= $email ?? 'email@example.com' ?></div>
                <div class="contact-item"><?= $phone ?? '123-456-7890' ?></div>
                <div class="contact-item"><?= $location ?? 'City, State' ?></div>
                <?php if(!empty($linkedin)): ?>
                <div class="contact-item">LinkedIn: <?= $linkedin ?></div>
                <?php endif; ?>
            </div>
        </header>

        <section>
            <div class="section-header">
                <div class="section-dot"></div>
                <h2 class="section-title">Summary</h2>
            </div>
            <p class="summary"><?= $summary ?? 'Professional summary goes here...' ?></p>
        </section>

        <section>
            <div class="section-header">
                <div class="section-dot"></div>
                <h2 class="section-title">Experience</h2>
            </div>
            
            <?php foreach($experience as $exp): ?>
            <div class="item">
                <div class="item-header">
                    <div class="item-title"><?= $exp['title'] ?></div>
                    <div class="item-date"><?= $exp['dates'] ?></div>
                </div>
                <div class="item-company"><?= $exp['company'] ?> • <?= $exp['location'] ?></div>
                <ul>
                    <?php if(!empty($exp['highlights'])): ?>
                        <?php foreach($exp['highlights'] as $hl): ?>
                        <li><?= $hl ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </section>

        <section>
            <div class="section-header">
                <div class="section-dot"></div>
                <h2 class="section-title">Education</h2>
            </div>
            
            <?php foreach($education as $edu): ?>
            <div class="item">
                <div class="item-header">
                    <div class="item-title"><?= $edu['degree'] ?></div>
                    <div class="item-date"><?= $edu['dates'] ?></div>
                </div>
                <div class="item-company"><?= $edu['school'] ?></div>
                <?php if(!empty($edu['gpa'])): ?>
                <div class="summary" style="margin-top: 5px;">GPA: <?= $edu['gpa'] ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </section>

        <section>
            <div class="section-header">
                <div class="section-dot"></div>
                <h2 class="section-title">Expertise</h2>
            </div>
            <div class="skills-container">
                <?php foreach($skills as $skill): ?>
                <span class="skill-tag"><?= $skill ?></span>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>
