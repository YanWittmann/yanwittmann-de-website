<?php
$tech_stack = [
        'Languages' => ['Java', 'Python', 'TypeScript', 'PHP', 'C#', 'SQL'],
        'Frameworks' => ['React', 'Spring Boot'],
        'Other' => ['Godot']
];
?>
<aside class="card sidebar padded center">
    <img src="/homepage/static/img/profile-picture-yan-<?= rand(1,4) ?>.webp" class="profile-pic no-card-image" alt="Profile">

    <h3 class="card-title" style="justify-content: center; font-size: 1.2rem; margin-bottom: 5px;">Yan Wittmann</h3>
    <div style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-light); margin-bottom: 5px;">
        HEIDELBERG, GERMANY
    </div>
    <div style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--accent); margin-bottom: 25px;">
        <?= (new DateTime("now", new DateTimeZone("Europe/Berlin")))->format('g:i A T') ?>
    </div>

    <div style="width: 100%; text-align: left; border-top: 1px solid #eee; padding-top: 20px; margin-bottom: 10px;">
        <?php foreach ($tech_stack as $category => $tags): ?>
            <div style="margin-bottom: 15px;">
                <h4 style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--text-main); margin: 0 0 8px 0; text-transform: uppercase;">
                    <?= htmlspecialchars($category) ?>
                </h4>
                <?php \App\View::partial('tags_list', ['tags' => $tags]); ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="socials">
        <a href="https://github.com/YanWittmann" aria-label="Link to the GitHub account of Yan Wittmann"><?= icon('github') ?></a>
        <a href="https://www.linkedin.com/in/yan-wittmann-b6a8562a9/" aria-label="Link to the LinkedIn account of Yan Wittmann"><?= icon('linkedin') ?></a>
        <a href="https://youtube.com/c/@Skyball" aria-label="Link to the YouTube account of Yan Wittmann"><?= icon('youtube') ?></a>
    </div>
</aside>