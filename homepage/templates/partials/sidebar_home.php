<aside class="card sidebar padded center home-sidebar">
    <img src="/static/img/profile-picture-yan.webp" class="profile-pic" alt="Profile">

    <ul class="meta-list">
        <li><i class="fa-regular fa-building"></i> <a href="https://metaeffekt.com">{metaeffekt}</a></li>
        <li><i class="fa-solid fa-location-dot"></i> <span>Heidelberg, Germany</span></li>
        <li><i class="fa-regular fa-clock"></i> <span><?= (new DateTime("now", new DateTimeZone("Europe/Berlin")))->format('g:i A T') ?></span></li>
    </ul>

    <div style="width: 100%; text-align: left; margin-bottom: 25px;">
        <h3 style="font-family: var(--font-mono); font-size: 0.8rem; text-transform: uppercase; margin-top:0;">Tech Stack</h3>
        <?php \App\View::partial('tags_list', ['tags' => ['Java', 'Maven', 'Python', 'React', 'TypeScript', 'PHP', 'SQL', 'Markdown']]); ?>
    </div>

    <div class="socials">
        <a href="https://github.com/YanWittmann"><i class="fa-brands fa-github"></i></a>
        <a href="https://www.linkedin.com/in/yan-wittmann-b6a8562a9/"><i class="fa-brands fa-linkedin"></i></a>
        <a href="https://youtube.com/c/@Skyball"><i class="fa-brands fa-youtube"></i></a>
    </div>
</aside>
