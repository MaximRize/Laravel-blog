<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Страница не найдена</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .game-container {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        canvas {
            border: 2px solid white;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.05);
            cursor: none;
        }
        .score {
            font-size: 24px;
            margin: 15px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 30px;
            background: white;
            color: #764ba2;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            transition: transform 0.3s;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        h1 {
            font-size: 72px;
            margin: 0;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body>
<div class="game-container">
    <h1>404</h1>
    <h2>Страница потерялась в космосе</h2>
    <p class="score">Очки: <span id="score">0</span></p>

    <canvas id="gameCanvas" width="500" height="300"></canvas>

    <div style="margin-top: 20px;">
        <p>Лови шарики, пока ищешь путь домой!</p>
        <a href="{{ url('/') }}" class="btn">Вернуться на главную</a>
    </div>
</div>

<script>
    const canvas = document.getElementById('gameCanvas');
    const ctx = canvas.getContext('2d');
    const scoreElement = document.getElementById('score');

    // Игрок - космический корабль
    let player = {
        x: canvas.width / 2,
        y: canvas.height - 30,
        radius: 10,
        speed: 5
    };

    // Массив шариков
    let balls = [];
    let score = 0;

    // Управление с клавиатуры
    let leftPressed = false;
    let rightPressed = false;

    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') leftPressed = true;
        if (e.key === 'ArrowRight') rightPressed = true;
    });

    document.addEventListener('keyup', (e) => {
        if (e.key === 'ArrowLeft') leftPressed = false;
        if (e.key === 'ArrowRight') rightPressed = false;
    });

    // Управление мышью
    canvas.addEventListener('mousemove', (e) => {
        const rect = canvas.getBoundingClientRect();
        player.x = e.clientX - rect.left;
        // Не даем выйти за границы
        if (player.x < player.radius) player.x = player.radius;
        if (player.x > canvas.width - player.radius) player.x = canvas.width - player.radius;
    });

    // Создание новых шариков
    function createBall() {
        balls.push({
            x: Math.random() * (canvas.width - 20) + 10,
            y: 10,
            radius: 8,
            speed: 2 + Math.random() * 3,
            color: `hsl(${Math.random() * 360}, 70%, 60%)`
        });
    }

    // Создаем шарики каждые 1.5 секунды
    setInterval(createBall, 1500);

    // Обновление игры
    function update() {
        // Движение игрока с клавиатуры
        if (leftPressed && player.x > player.radius) {
            player.x -= player.speed;
        }
        if (rightPressed && player.x < canvas.width - player.radius) {
            player.x += player.speed;
        }

        // Движение шариков
        for (let i = balls.length - 1; i >= 0; i--) {
            balls[i].y += balls[i].speed;

            // Проверка столкновения с игроком
            const dx = balls[i].x - player.x;
            const dy = balls[i].y - player.y;
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < balls[i].radius + player.radius) {
                balls.splice(i, 1);
                score += 10;
                scoreElement.textContent = score;
            }
            // Если шарик улетел вниз
            else if (balls[i].y - balls[i].radius > canvas.height) {
                balls.splice(i, 1);
            }
        }
    }

    // Отрисовка
    function draw() {
        // Очищаем canvas
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Рисуем звезды
        ctx.fillStyle = 'white';
        for (let i = 0; i < 50; i++) {
            if (i % 2 === 0) continue; // анимация мерцания
            ctx.beginPath();
            ctx.arc(
                (i * 17) % canvas.width,
                (Date.now() * 0.01 + i * 23) % canvas.height,
                1, 0, Math.PI * 2
            );
            ctx.fill();
        }

        // Рисуем шарики
        balls.forEach(ball => {
            ctx.beginPath();
            ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
            ctx.fillStyle = ball.color;
            ctx.fill();

            // Блик
            ctx.beginPath();
            ctx.arc(ball.x - 2, ball.y - 2, 2, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(255, 255, 255, 0.5)';
            ctx.fill();
        });

        // Рисуем игрока (космический корабль)
        ctx.beginPath();
        ctx.arc(player.x, player.y, player.radius, 0, Math.PI * 2);
        ctx.fillStyle = '#ffd700';
        ctx.fill();

        // Крылья корабля
        ctx.beginPath();
        ctx.moveTo(player.x - 15, player.y);
        ctx.lineTo(player.x - 25, player.y + 10);
        ctx.lineTo(player.x - 15, player.y + 5);
        ctx.fillStyle = '#ffa500';
        ctx.fill();

        ctx.beginPath();
        ctx.moveTo(player.x + 15, player.y);
        ctx.lineTo(player.x + 25, player.y + 10);
        ctx.lineTo(player.x + 15, player.y + 5);
        ctx.fillStyle = '#ffa500';
        ctx.fill();
    }

    // Игровой цикл
    function gameLoop() {
        update();
        draw();
        requestAnimationFrame(gameLoop);
    }

    gameLoop();
</script>
</body>
</html>
