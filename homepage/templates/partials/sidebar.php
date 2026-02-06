<aside class="sidebar-card">
    <img src="/static/img/profile-picture-yan.webp" class="profile-pic" alt="Profile">

    <ul class="meta-list">
        <li><i class="fa-regular fa-building"></i> <a href="https://metaeffekt.com">{metaeffekt}</a></li>
        <li><i class="fa-solid fa-location-dot"></i> <span>Heidelberg, Germany</span></li>
        <li><i class="fa-regular fa-clock"></i> <span><?= (new DateTime("now", new DateTimeZone("Europe/Berlin")))->format('g:i A T') ?></span></li>
    </ul>

    <div class="tech-stack">
        <h3>Tech Stack</h3>
        <div class="tech-tags-sidebar">
            <span class="tag">Java</span>
            <span class="tag">Maven</span>
            <span class="tag">Python</span>
            <span class="tag">React</span>
            <span class="tag">TypeScript</span>
            <span class="tag">PHP</span>
            <span class="tag">SQL</span>
            <span class="tag">Markdown</span>
        </div>
    </div>

    <div class="socials">
        <a href="https://github.com/YanWittmann"><i class="fa-brands fa-github"></i></a>
        <a href="https://www.linkedin.com/in/yan-wittmann-b6a8562a9/"><i class="fa-brands fa-linkedin"></i></a>
        <a href="https://youtube.com/c/@Skyball"><i class="fa-brands fa-youtube"></i></a>
    </div>
</aside>