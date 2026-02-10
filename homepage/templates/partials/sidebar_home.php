<aside class="card sidebar padded center">
    <img src="/static/img/profile-picture-yan.webp" class="profile-pic" alt="Profile">

    <h3 class="card-title" style="justify-content: center; font-size: 1.2rem; margin-bottom: 5px;">Yan Wittmann</h3>
    <div style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--text-light); margin-bottom: 5px;">
        HEIDELBERG, GERMANY
    </div>
    <div style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--accent); margin-bottom: 20px;">
        <?= (new DateTime("now", new DateTimeZone("Europe/Berlin")))->format('g:i A T') ?>
    </div>

    <div style="width: 100%; text-align: left; border-top: 1px solid #eee; padding-top: 15px; margin-bottom: 25px;">
        <h4 style="font-family: var(--font-mono); font-size: 0.75rem; color: #999; margin: 0 0 10px 0;">TECH STACK</h4>
        <?php \App\View::partial('tags_list', ['tags' => ['Java', 'Maven', 'Python', 'React', 'TypeScript', 'PHP', 'SQL', 'Markdown']]); ?>
    </div>

    <div class="socials">
        <a href="https://github.com/YanWittmann"><i class="fa-brands fa-github"></i></a>
        <a href="https://www.linkedin.com/in/yan-wittmann-b6a8562a9/"><i class="fa-brands fa-linkedin"></i></a>
        <a href="https://youtube.com/c/@Skyball"><i class="fa-brands fa-youtube"></i></a>
    </div>
</aside>