<style>
    .layout-grid {
        grid-template-columns: 1fr 1px;
    }
</style>

<div class="cards-grid">
    <?php foreach ($messages as $msg): ?>
        <article class="card fit-content">
            <header class="card-header">
                <h3 class="card-title">
                    <span class="card-square"></span>
                    <?= htmlspecialchars($msg['author'] ?? 'Anonymous') ?>
                    // <?= htmlspecialchars($msg['id'] ?? 'no-id') ?>
                </h3>
                <span style="font-family: var(--font-mono); font-size: 0.75rem; color: var(--text-light);">
                        <?= date('Y-m-d H:i', strtotime($msg['created_at'])) ?>
                </span>
            </header>

            <?php if (!empty($msg['image_data'])): ?>
                <!-- Base64 Image -->
                <a href="<?= htmlspecialchars($msg['image_data']) ?>" download="sketch-<?= $msg['id'] ?>.png">
                    <img src="<?= htmlspecialchars($msg['image_data']) ?>" loading="lazy"
                         alt="Drawing by <?= htmlspecialchars($msg['author']) ?>" style="width: 100%; display: block;">
                </a>
            <?php endif; ?>

            <?php if (!empty($msg['note'])): ?>
                <div class="card-content">
                    <p style="margin: 0; color: var(--text-main); font-size: 0.95rem; line-height: 1.5;">
                        <?= nl2br(htmlspecialchars($msg['note'])) ?>
                    </p>
                </div>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</div>

<?php if (empty($messages)): ?>
    <p style="text-align: center; font-family: var(--font-mono); color: var(--text-light); margin-top: 50px;">
        No submissions found in the database.
    </p>
<?php endif; ?>
