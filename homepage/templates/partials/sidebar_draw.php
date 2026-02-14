<aside id="guestbook-widget" class="card sidebar guestbook-accordion" style="margin-top: 28px;">
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
            border-top: 1px solid var(--border-color);
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
            background: #fff;
            position: relative;
            line-height: 0;
        }

        .guestbook-canvas {
            display: block;
            width: 100%;
            touch-action: none;
            cursor: crosshair;
        }

        .guestbook-controls-row {
            display: flex;
            gap: 8px;
            margin-bottom: 8px;
            align-items: center;
        }

        .guestbook-color-picker {
            height: 34px;
            width: 40px;
            padding: 0;
            border: 1px solid #ccc;
            cursor: pointer;
            background: none;
        }

        #gb-canvas {
            display: block;
            width: 100%;
            cursor: crosshair;
            position: relative;
            background: transparent;
        }
    </style>

    <!-- Accordion Header -->
    <div class="card-header" style="cursor: pointer;" onclick="toggleGuestbook()">
        <h3 class="card-title">
            <span class="card-square"></span>
            Guestbook
        </h3>
        <span id="guestbook-arrow" class="arrow-icon">▼</span>
    </div>

    <!-- Expandable Body -->
    <div class="expandable-content">
        <div style="padding: 15px;">

            <div class="guestbook-canvas-container">
                <canvas id="gb-canvas" height="180"></canvas>
            </div>

            <div class="guestbook-controls-row">
                <input type="color" id="gb-color" class="guestbook-color-picker" value="#b61c52" title="Brush Color">
                <button type="button" id="gb-clear" class="btn secondary" style="flex-grow: 1; padding: 6px; font-size: 0.8rem;">Clear</button>
            </div>

            <input type="text" id="gb-author" class="guestbook-input" placeholder="Your Name" maxlength="50">

            <textarea id="gb-note" class="guestbook-input guestbook-textarea" placeholder="Leave a note..." maxlength="200"></textarea>

            <button type="button" id="gb-send" class="btn primary" style="width: 100%;">Send Entry</button>

            <div id="gb-status" style="margin-top: 10px; font-size: 0.8rem; text-align: center; font-family: var(--font-mono);"></div>
        </div>
    </div>

    <script>
        // Scope variables to avoid global pollution
        (function() {
            const widget = document.getElementById('guestbook-widget');
            const canvas = document.getElementById('gb-canvas');
            const ctx = canvas.getContext('2d');
            const colorPicker = document.getElementById('gb-color');
            const btnClear = document.getElementById('gb-clear');
            const btnSend = document.getElementById('gb-send');
            const statusDiv = document.getElementById('gb-status');

            // --- 1. Accordion Logic ---
            window.toggleGuestbook = function() {
                widget.classList.toggle('open');
            };

            // --- 2. Canvas Logic ---
            // Resize canvas to match container width dynamically
            function resizeCanvas() {
                const rect = canvas.parentElement.getBoundingClientRect();
                if (rect.width > 0 && canvas.width !== rect.width) {
                    // Save content before resize? Not strictly needed if closed, but good practice
                    // For now simple reset on resize to keep coordinate system simple
                    canvas.width = rect.width;
                }
            }

            // Initial sizing
            // We need a slight delay or check because if it's display:none/height:0 it might be 0
            // But since max-height animates, width is usually present.
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
                // If accordion is closed, don't draw (edge case)
                if (!widget.classList.contains('open')) return;

                isDrawing = true;
                const coords = getCoords(e);
                lastX = coords.x;
                lastY = coords.y;

                // Draw a dot
                ctx.fillStyle = colorPicker.value;
                ctx.beginPath();
                ctx.arc(lastX, lastY, 1, 0, Math.PI * 2);
                ctx.fill();

                e.preventDefault(); // Prevent scrolling on touch
            }

            function move(e) {
                if (!isDrawing) return;
                e.preventDefault();

                const coords = getCoords(e);
                ctx.strokeStyle = colorPicker.value;
                ctx.lineWidth = 2;

                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(coords.x, coords.y);
                ctx.stroke();

                lastX = coords.x;
                lastY = coords.y;
            }

            function stop() {
                isDrawing = false;
            }

            canvas.addEventListener('mousedown', start);
            canvas.addEventListener('mousemove', move);
            canvas.addEventListener('mouseup', stop);
            canvas.addEventListener('mouseout', stop);

            canvas.addEventListener('touchstart', start, { passive: false });
            canvas.addEventListener('touchmove', move, { passive: false });
            canvas.addEventListener('touchend', stop);

            // --- 3. Controls ---
            btnClear.addEventListener('click', () => {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            });

            // --- 4. Send Logic ---
            btnSend.addEventListener('click', () => {
                const author = document.getElementById('gb-author').value.trim();
                const note = document.getElementById('gb-note').value.trim();

                // Check for empty canvas
                const blank = document.createElement('canvas');
                blank.width = canvas.width;
                blank.height = canvas.height;
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
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            statusDiv.style.color = 'green';
                            statusDiv.textContent = 'Thanks for your entry!';

                            // Clear form
                            ctx.clearRect(0, 0, canvas.width, canvas.height);
                            document.getElementById('gb-note').value = '';
                            // document.getElementById('gb-author').value = ''; // Keep author name for convenience?

                            // Close after a moment
                            setTimeout(() => {
                                widget.classList.remove('open');
                                statusDiv.textContent = '';
                            }, 2000);
                        } else {
                            throw new Error(data.message || 'Error');
                        }
                    })
                    .catch(err => {
                        statusDiv.style.color = 'var(--accent)';
                        statusDiv.textContent = 'Failed to send.';
                        console.error(err);
                    })
                    .finally(() => {
                        btnSend.disabled = false;
                        btnSend.textContent = 'Send Entry';
                    });
            });

        })();
    </script>
</aside>