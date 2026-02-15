<?php
$guestbook_colors = [
        '#b61c52', '#d94f4f', '#ea9b3e', '#4caf50', '#4a90e2', '#9013fe', '#2f2f2f', '#ffffff',
];
$emoji_array = [":)", ":)", ":)", ":)", ":)", ":)", "UwU", ";-)", ":]", "=D"];
$emoji = array_rand($emoji_array);
$emoji = $emoji_array[$emoji];
?>

<style>
    /* --- Draw Widget --- */
    .guestbook-accordion {
        height: fit-content;
    }

    .guestbook-accordion .expandable-content {
        max-height: 0;
        transition: max-height 0.4s ease-out;
        background: #fff;
        overflow: hidden;
    }

    .guestbook-accordion.open .expandable-content {
        max-height: 800px;
    }

    .guestbook-accordion .arrow-icon {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
        color: var(--text-light);
    }

    .guestbook-accordion.open .arrow-icon {
        transform: rotate(180deg);
        color: var(--accent);
    }

    .guestbook-input {
        width: 100%;
        padding: 8px;
        margin-bottom: 8px;
        border: 1px solid var(--border-color);
        font-family: var(--font-body);
        font-size: 0.85rem;
        background: #fff;
        border-radius: 0;
    }

    .guestbook-input:focus {
        outline: 2px solid var(--accent);
        border-color: var(--accent);
    }

    .guestbook-textarea {
        resize: none;
        height: 60px;
        font-family: var(--font-body);
    }

    .guestbook-canvas-container {
        width: 100%;
        border: 1px dashed var(--text-light);
        margin-bottom: 8px;
        position: relative;
        line-height: 0;
    }

    .guestbook-canvas {
        display: block;
        width: 100%;
        touch-action: none;
        cursor: crosshair;
    }

    .guestbook-clear-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        z-index: 10;
        width: 24px;
        height: 24px;
        background: rgba(255, 255, 255);
        border: 1px solid var(--border-color);
        font-size: 16px;
        line-height: 22px;
        text-align: center;
        cursor: pointer;
        color: var(--text-main);
        font-family: sans-serif;
        padding: 0;
    }

    .guestbook-clear-btn:hover {
        background: white;
        color: var(--accent);
        border-color: var(--accent);
    }

    .guestbook-color-palette {
        display: grid;
        grid-template-columns: repeat(<?= count($guestbook_colors) ?>, 1fr);
        gap: 5px;
        margin-bottom: 8px;
    }

    .guestbook-color-swatch {
        width: 100%;
        aspect-ratio: 1 / 1;
        border: 2px solid var(--border-color);
        cursor: pointer;
        position: relative;
        background-color: #fff;
        padding: 0;
    }

    .guestbook-color-swatch:hover {
        border-color: var(--accent);
    }

    .guestbook-color-swatch.active::after {
        content: '';
        position: absolute;
        bottom: -5px;
        right: -5px;
        border: 2px solid var(--border-color);
        background: var(--accent);
        border-radius: 50%;
        width: 10px;
        height: 10px;
    }
</style>

<aside id="guestbook-widget" class="card sidebar guestbook-accordion" style="margin-top: 28px;">
    <!-- Accordion Header -->
    <div class="card-header" style="cursor: pointer;" onclick="toggleGuestbook()">
        <h3 class="card-title">
            <span class="card-square"></span>
            Leave a Sketch for me!
        </h3>
        <span id="guestbook-arrow" class="arrow-icon">▼</span>
    </div>

    <!-- Expandable Body -->
    <div class="expandable-content">
        <div style="padding: 15px;">

            <div class="guestbook-canvas-container">
                <canvas id="gb-canvas" height="200"></canvas>
                <button type="button" id="gb-clear" class="guestbook-clear-btn" title="Clear Canvas">&times;</button>
            </div>

            <div id="gb-color-palette" class="guestbook-color-palette">
                <?php foreach ($guestbook_colors as $index => $color): ?>
                    <button class="guestbook-color-swatch <?= $index === 0 ? 'active' : '' ?>"
                            data-color="<?= htmlspecialchars($color) ?>"
                            style="background-color: <?= htmlspecialchars($color) ?>;"></button>
                <?php endforeach; ?>
            </div>

            <input type="text" id="gb-author" class="guestbook-input" placeholder="Your Name" maxlength="50">
            <textarea id="gb-note" class="guestbook-input guestbook-textarea" placeholder="Leave a note..."
                      maxlength="255"></textarea>

            <div style="display: flex; gap: 8px;">
                <button type="button" id="gb-send" class="btn primary" style="width: 100%;">
                    Send Card <?= $emoji ?>
                </button>
            </div>

            <div id="gb-status"
                 style="margin-top: 10px; font-size: 0.8rem; text-align: center; font-family: var(--font-mono);"></div>
        </div>
    </div>

    <script>
        // Scope variables to avoid global pollution
        (function () {
            const widget = document.getElementById('guestbook-widget');
            const canvas = document.getElementById('gb-canvas');
            const ctx = canvas.getContext('2d');
            const colorPalette = document.getElementById('gb-color-palette');
            const btnClear = document.getElementById('gb-clear');
            const btnSend = document.getElementById('gb-send');
            const statusDiv = document.getElementById('gb-status');

            let currentColor = '<?= htmlspecialchars($guestbook_colors[0]) ?>';

            // --- 1. Accordion Logic ---
            window.toggleGuestbook = function () {
                widget.classList.toggle('open');
            };

            // --- 2. Canvas Logic ---
            function fillWhite() {
                ctx.fillStyle = '#ffffff';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
            }

            function resizeCanvas() {
                const container = canvas.parentElement;
                const innerWidth = container.clientWidth;
                if (innerWidth > 0 && canvas.width !== innerWidth) {
                    canvas.width = innerWidth;
                    fillWhite();
                }
            }

            setTimeout(resizeCanvas, 100);
            window.addEventListener('resize', resizeCanvas);

            ctx.lineJoin = 'round';
            ctx.lineCap = 'round';
            ctx.lineWidth = 2;

            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;

            function getCoords(e) {
                const rect = canvas.getBoundingClientRect();
                const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            }

            function start(e) {
                if (!widget.classList.contains('open')) return;

                isDrawing = true;
                const coords = getCoords(e);
                lastX = coords.x;
                lastY = coords.y;

                // Ensure full opacity for the starting dot
                ctx.globalAlpha = 1.0;
                ctx.fillStyle = currentColor;
                ctx.beginPath();
                ctx.arc(lastX, lastY, currentColor === '#ffffff' ? 3 : 1, 0, Math.PI * 2);
                ctx.fill();

                e.preventDefault();
            }

            function move(e) {
                if (!isDrawing) return;
                e.preventDefault();

                const coords = getCoords(e);
                const isEraser = currentColor === '#ffffff';

                ctx.beginPath();
                ctx.moveTo(lastX, lastY);

                if (isEraser) {
                    // Eraser: standard, consistent thick line
                    ctx.lineWidth = 10;
                    ctx.globalAlpha = 1.0;
                    ctx.strokeStyle = currentColor;
                    ctx.lineTo(coords.x, coords.y);
                    ctx.stroke();
                } else {
                    // Brush: Organic / Sketchy / Wiggly
                    // 1. Vary width slightly per segment
                    ctx.lineWidth = 3 + (Math.random() * 0.5);

                    // 2. Vary opacity per segment (simulating pressure/ink flow)
                    ctx.globalAlpha = 0.5 + Math.random() * 0.5;

                    ctx.strokeStyle = currentColor;

                    // 3. Jittery Curve (Displacement + Wiggle)
                    // Instead of a straight line, draw a curve to the new point
                    // utilizing a control point that is slightly offset from the midpoint.
                    const midX = (lastX + coords.x) / 2;
                    const midY = (lastY + coords.y) / 2;

                    // Jitter amount (higher = more wiggly)
                    const jitter = 5;
                    const jitterX = Math.random() * jitter - (jitter / 2);
                    const jitterY = Math.random() * jitter - (jitter / 2);

                    ctx.quadraticCurveTo(midX + jitterX, midY + jitterY, coords.x, coords.y);
                    ctx.stroke();
                }

                lastX = coords.x;
                lastY = coords.y;

                // Reset alpha to avoid affecting other drawing operations
                ctx.globalAlpha = 1.0;
            }

            function stop() {
                isDrawing = false;
                ctx.globalAlpha = 1.0;
            }

            canvas.addEventListener('mousedown', start);
            canvas.addEventListener('mousemove', move);
            canvas.addEventListener('mouseup', stop);
            canvas.addEventListener('mouseout', stop);

            canvas.addEventListener('touchstart', start, { passive: false });
            canvas.addEventListener('touchmove', move, { passive: false });
            canvas.addEventListener('touchend', stop);

            colorPalette.addEventListener('click', (e) => {
                const target = e.target.closest('.guestbook-color-swatch');
                if (!target) return;

                currentColor = target.dataset.color;

                const currentActive = colorPalette.querySelector('.active');
                if (currentActive) currentActive.classList.remove('active');
                target.classList.add('active');
            });

            // --- 3. Controls ---
            btnClear.addEventListener('click', () => {
                fillWhite();
            });

            // --- 4. Send Logic ---
            btnSend.addEventListener('click', () => {
                const author = document.getElementById('gb-author').value.trim();
                const note = document.getElementById('gb-note').value.trim();

                const blank = document.createElement('canvas');
                blank.width = canvas.width;
                blank.height = canvas.height;
                const bCtx = blank.getContext('2d');
                bCtx.fillStyle = '#ffffff';
                bCtx.fillRect(0, 0, blank.width, blank.height);

                if (canvas.toDataURL() === blank.toDataURL()) {
                    statusDiv.style.color = 'var(--accent)';
                    statusDiv.textContent = 'Please draw something!';
                    return;
                }

                const imageData = canvas.toDataURL('image/png');

                btnSend.disabled = true;
                btnSend.textContent = 'Sending...';
                statusDiv.textContent = '';

                fetch('/api/guestbook', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ author, note, image: imageData })
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Server error');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            statusDiv.style.color = 'green';
                            statusDiv.textContent = 'Thanks for your entry!';
                            fillWhite();
                            document.getElementById('gb-note').value = '';
                            document.getElementById('gb-author').value = '';
                            setTimeout(() => {
                                widget.classList.remove('open');
                                statusDiv.textContent = '';
                            }, 2000);
                        } else {
                            throw new Error(data.message || 'Woah! Something went wrong.');
                        }
                    })
                    .catch(err => {
                        statusDiv.style.color = 'var(--accent)';
                        statusDiv.textContent = err.message ?? 'Failed to send.';
                        console.error(err);
                    })
                    .finally(() => {
                        btnSend.disabled = false;
                        btnSend.textContent = 'Send Card <?= $emoji ?>';
                    });
            });

        })();
    </script>
</aside>