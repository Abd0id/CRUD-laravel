<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel CRUD Quest - Database Master</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background-color: #0A0A14;
            color: #E0E0E0;
            font-family: 'Space Mono', monospace;
            overflow-x: hidden;
        }

        /* Animated Grid Background */
        .grid-bg {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(138, 43, 226, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(138, 43, 226, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: grid-scroll 25s linear infinite;
            pointer-events: none;
            z-index: 0;
        }

        /* Database Particles */
        .db-particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
        }

        .db-particle {
            position: absolute;
            font-size: 20px;
            opacity: 0.1;
            animation: float-particle 15s linear infinite;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 10;
        }

        /* Header */
        header {
            text-align: center;
            margin-bottom: 3rem;
            animation: glitch-in 0.8s ease-out;
        }

        header h1 {
            font-family: 'Press Start 2P', cursive;
            font-size: clamp(1.5rem, 5vw, 3rem);
            color: #8A2BE2;
            margin-bottom: 1rem;
            line-height: 1.6;
            text-shadow: 0 0 10px #8A2BE2, 0 0 20px #8A2BE2, 3px 3px 0 #FF1493;
            cursor: pointer;
            transition: transform 0.1s ease-out;
            user-select: none;
        }

        header h1:hover {
            animation: title-glitch 0.3s ease-out;
        }

        header p {
            font-size: 1.25rem;
            color: #00CED1;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            animation: blink 2s infinite;
        }

        .subtitle {
            font-size: 1rem;
            color: #FFD700;
            margin-top: 0.5rem;
        }

        /* Progress Section */
        .progress-section {
            background: linear-gradient(135deg, #1A0F2E, #2D1B4E);
            border: 2px solid #8A2BE2;
            border-radius: 0.5rem;
            padding: 2rem;
            margin-bottom: 3rem;
            animation: slide-in 0.6s ease-out 0.5s both;
            box-shadow: 0 0 30px rgba(138, 43, 226, 0.3);
        }

        .progress-title {
            font-family: 'Press Start 2P', cursive;
            font-size: 1rem;
            color: #00CED1;
            margin-bottom: 1rem;
            text-align: center;
        }

        .progress-bar-container {
            width: 100%;
            height: 2rem;
            background: #0A0A14;
            border: 2px solid #8A2BE2;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(to right, #8A2BE2, #FF1493, #00CED1);
            transition: width 1s ease-out;
            animation: progress-pulse 2s ease-in-out infinite;
        }

        .progress-text {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.75rem;
            color: white;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.8);
        }

        .progress-hint {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.875rem;
            opacity: 0.8;
        }

        /* CRUD Stats */
        .crud-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: rgba(138, 43, 226, 0.1);
            border: 2px solid #8A2BE2;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            border-color: #FF1493;
            box-shadow: 0 0 20px rgba(255, 20, 147, 0.4);
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
            color: #00CED1;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.5rem;
            color: #FFD700;
            font-weight: bold;
        }

        /* Quest Cards */
        .quest-grid {
            display: grid;
            gap: 2rem;
        }

        .quest-card {
            position: relative;
            background: linear-gradient(135deg, #1A0F2E 0%, #0D0616 100%);
            border: 2px solid #444;
            border-radius: 0.5rem;
            padding: 2rem;
            overflow: hidden;
            transition: all 0.3s ease;
            opacity: 0.5;
        }

        .quest-card.unlocked {
            border-color: #8A2BE2;
            opacity: 1;
        }

        .quest-card.unlocked:hover {
            border-color: #FF1493;
            transform: translateX(10px);
            box-shadow: 0 0 30px rgba(255, 20, 147, 0.3), inset 0 0 30px rgba(138, 43, 226, 0.1);
        }

        .quest-card.animating-unlock {
            animation: card-unlock-full 1s ease-out forwards;
        }

        .quest-card.animating-lock {
            animation: card-lock-full 0.6s ease-out forwards;
        }

        /* Lock Button */
        .lock-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 3rem;
            z-index: 10;
            cursor: pointer;
            background: none;
            border: none;
            transition: all 0.3s ease;
            opacity: 0.5;
            filter: drop-shadow(0 0 10px rgba(138, 43, 226, 0.5));
        }

        .lock-btn:hover {
            transform: scale(1.25);
            opacity: 1;
            filter: drop-shadow(0 0 20px rgba(138, 43, 226, 0.8));
        }

        .lock-btn:active {
            transform: scale(0.9);
        }

        .quest-card.unlocked .lock-btn {
            opacity: 0.8;
        }

        .lock-btn .lock-icon {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .lock-btn.shaking .lock-icon {
            animation: lock-shake 0.6s ease-in-out;
        }

        .lock-btn.glowing-unlock {
            animation: unlock-glow-full 1s ease-out;
        }

        .lock-btn.glowing-lock {
            animation: lock-glow-full 0.6s ease-out;
        }

        .lock-btn.bouncing .lock-icon {
            animation: lock-bounce 0.4s ease-out;
        }

        /* Card Content */
        .quest-header {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        @media (min-width: 768px) {
            .quest-header {
                flex-direction: row;
                align-items: flex-start;
            }
        }

        .quest-level {
            font-family: 'Press Start 2P', cursive;
            font-size: 2.5rem;
            min-width: 80px;
            color: #444;
            transition: all 0.5s ease;
        }

        .quest-card.unlocked .quest-level {
            color: #8A2BE2;
            text-shadow: 0 0 10px #8A2BE2;
        }

        .quest-level.pop {
            animation: level-pop 0.5s ease-out;
        }

        .quest-info {
            flex: 1;
        }

        .quest-title {
            font-family: 'Press Start 2P', cursive;
            font-size: 1.25rem;
            color: #FF1493;
            margin-bottom: 0.5rem;
            line-height: 1.6;
        }

        .quest-description {
            color: #E0E0E0;
            line-height: 1.6;
        }

        /* CRUD Badges */
        .badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        .badge-create {
            background: #4CAF50;
            color: white;
        }

        .badge-read {
            background: #2196F3;
            color: white;
        }

        .badge-update {
            background: #FF9800;
            color: white;
        }

        .badge-delete {
            background: #F44336;
            color: white;
        }

        .badge-migration {
            background: #9C27B0;
            color: white;
        }

        .badge-master {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #0A0A14;
        }

        .badge.pulse {
            animation: badge-pulse 0.6s ease-out;
        }

        /* Code Block */
        .code-block {
            background: black;
            border: 1px solid #8A2BE2;
            border-radius: 4px;
            padding: 1rem;
            font-family: 'Space Mono', monospace;
            font-size: 0.875rem;
            box-shadow: inset 0 0 10px rgba(138, 43, 226, 0.2);
            overflow-x: auto;
            transition: all 0.5s ease;
        }

        .code-block.glow {
            box-shadow: inset 0 0 10px rgba(138, 43, 226, 0.2), 0 0 20px rgba(138, 43, 226, 0.4);
        }

        .code-block code {
            color: #8A2BE2;
            white-space: pre-wrap;
        }

        /* Stats */
        .quest-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 1rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .stat-item.highlight {
            animation: stat-highlight 0.5s ease-out;
        }

        .stat-item .stat-icon {
            color: #00CED1;
            font-size: 1rem;
        }

        /* Action Button */
        .quest-btn {
            display: inline-block;
            margin-top: 1.5rem;
            padding: 1rem 2rem;
            border-radius: 4px;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.75rem;
            text-transform: uppercase;
            text-decoration: none;
            background: linear-gradient(to bottom right, #8A2BE2, #FF1493);
            color: white;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            border: none;
        }

        .quest-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.3), 0 0 20px #8A2BE2;
        }

        .quest-btn:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.3);
        }

        .quest-card:not(.unlocked) .quest-btn {
            pointer-events: none;
            opacity: 0.5;
        }

        .quest-btn.reveal {
            animation: btn-reveal 0.5s ease-out;
        }

        /* Reset Button */
        .reset-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
            background: rgba(255, 68, 68, 0.9);
            border: 2px solid #FF4444;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-family: 'Space Mono', monospace;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 68, 68, 0.3);
            backdrop-filter: blur(4px);
        }

        .reset-btn:hover {
            background: #FF4444;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 68, 68, 0.5);
        }

        .reset-btn:active {
            transform: translateY(0);
        }

        /* Particles */
        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: particle-fly 1s ease-out forwards;
        }

        /* ==================== ANIMATIONS ==================== */

        @keyframes grid-scroll {
            0% { transform: translateY(0); }
            100% { transform: translateY(40px); }
        }

        @keyframes float-particle {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.1;
            }
            90% {
                opacity: 0.1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes glitch-in {
            0% {
                opacity: 0;
                transform: translateY(-20px);
                filter: blur(10px);
            }
            50% {
                transform: translateX(-5px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        @keyframes title-glitch {
            0% {
                transform: translate(0);
                text-shadow: 0 0 10px #8A2BE2, 0 0 20px #8A2BE2, 3px 3px 0 #FF1493;
            }
            20% {
                transform: translate(-2px, 2px);
                text-shadow: -2px 0 #FF1493, 2px 0 #8A2BE2, 0 0 20px #8A2BE2;
            }
            40% {
                transform: translate(2px, -2px);
                text-shadow: 2px 0 #FF1493, -2px 0 #8A2BE2, 0 0 30px #00CED1;
            }
            60% {
                transform: translate(-2px, -2px);
                text-shadow: 0 -2px #FF1493, 0 2px #8A2BE2, 0 0 20px #8A2BE2;
            }
            80% {
                transform: translate(2px, 2px);
                text-shadow: 2px 2px #00CED1, -2px -2px #FF1493, 0 0 15px #8A2BE2;
            }
            100% {
                transform: translate(0);
                text-shadow: 0 0 10px #8A2BE2, 0 0 20px #8A2BE2, 3px 3px 0 #FF1493;
            }
        }

        @keyframes slide-in {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes blink {
            0%, 49% { opacity: 1; }
            50%, 100% { opacity: 0.3; }
        }

        @keyframes progress-pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        @keyframes lock-shake {
            0%, 100% { transform: rotate(0deg) scale(1); }
            10% { transform: rotate(-20deg) scale(1.1); }
            20% { transform: rotate(20deg) scale(1.15); }
            30% { transform: rotate(-20deg) scale(1.1); }
            40% { transform: rotate(20deg) scale(1.05); }
            50% { transform: rotate(-15deg) scale(1.1); }
            60% { transform: rotate(15deg) scale(1.05); }
            70% { transform: rotate(-10deg) scale(1); }
            80% { transform: rotate(10deg) scale(1); }
            90% { transform: rotate(-5deg) scale(1); }
        }

        @keyframes lock-bounce {
            0% { transform: scale(1); }
            30% { transform: scale(1.4); }
            50% { transform: scale(0.9); }
            70% { transform: scale(1.15); }
            100% { transform: scale(1); }
        }

        @keyframes card-unlock-full {
            0% {
                border-color: #444;
                opacity: 0.5;
                box-shadow: none;
            }
            20% {
                border-color: #FF1493;
                box-shadow: 0 0 30px rgba(255, 20, 147, 0.6), inset 0 0 20px rgba(255, 20, 147, 0.2);
            }
            40% {
                border-color: #00CED1;
                box-shadow: 0 0 50px rgba(0, 206, 209, 0.7), inset 0 0 30px rgba(0, 206, 209, 0.3);
            }
            60% {
                border-color: #8A2BE2;
                opacity: 1;
                box-shadow: 0 0 60px rgba(138, 43, 226, 0.8), inset 0 0 40px rgba(138, 43, 226, 0.3);
            }
            80% {
                box-shadow: 0 0 40px rgba(138, 43, 226, 0.5), inset 0 0 20px rgba(138, 43, 226, 0.15);
            }
            100% {
                border-color: #8A2BE2;
                opacity: 1;
                box-shadow: 0 0 15px rgba(138, 43, 226, 0.3);
            }
        }

        @keyframes card-lock-full {
            0% {
                border-color: #8A2BE2;
                opacity: 1;
                box-shadow: 0 0 15px rgba(138, 43, 226, 0.3);
            }
            30% {
                border-color: #FF4444;
                box-shadow: 0 0 30px rgba(255, 68, 68, 0.5);
            }
            60% {
                border-color: #666;
                box-shadow: 0 0 20px rgba(100, 100, 100, 0.3);
            }
            100% {
                border-color: #444;
                opacity: 0.5;
                box-shadow: none;
            }
        }

        @keyframes unlock-glow-full {
            0% {
                filter: drop-shadow(0 0 10px rgba(138, 43, 226, 0.5));
            }
            25% {
                filter: drop-shadow(0 0 30px rgba(255, 20, 147, 1)) drop-shadow(0 0 60px rgba(255, 20, 147, 0.8));
            }
            50% {
                filter: drop-shadow(0 0 40px rgba(138, 43, 226, 1)) drop-shadow(0 0 80px rgba(138, 43, 226, 0.6));
            }
            75% {
                filter: drop-shadow(0 0 30px rgba(138, 43, 226, 0.8));
            }
            100% {
                filter: drop-shadow(0 0 15px rgba(138, 43, 226, 0.5));
            }
        }

        @keyframes lock-glow-full {
            0% {
                filter: drop-shadow(0 0 15px rgba(138, 43, 226, 0.5));
            }
            30% {
                filter: drop-shadow(0 0 25px rgba(255, 68, 68, 0.8));
            }
            60% {
                filter: drop-shadow(0 0 15px rgba(255, 68, 68, 0.5));
            }
            100% {
                filter: drop-shadow(0 0 10px rgba(138, 43, 226, 0.5));
            }
        }

        @keyframes level-pop {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }

        @keyframes badge-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.15); box-shadow: 0 0 20px currentColor; }
            100% { transform: scale(1); }
        }

        @keyframes stat-highlight {
            0% { transform: translateX(0); opacity: 0.5; }
            50% { transform: translateX(5px); opacity: 1; }
            100% { transform: translateX(0); opacity: 1; }
        }

        @keyframes btn-reveal {
            0% { transform: scale(0.8); opacity: 0.5; }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes particle-fly {
            0% {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }
            100% {
                opacity: 0;
                transform: translate(var(--tx), var(--ty)) scale(0);
            }
        }
    </style>
</head>
<body>
<div class="grid-bg"></div>

<!-- Database Particles -->
<div class="db-particles" id="dbParticles"></div>

<div class="container">
    <header>
        <h1 id="mainTitle">Laravel CRUD Quest</h1>
        <p>&#9654; Database Master Challenge &#9664;</p>
        <p class="subtitle">De la migration à la maîtrise</p>
    </header>

    <section class="progress-section">
        <div class="progress-title">&#128190; Progression CRUD</div>
        <div class="progress-bar-container">
            <div class="progress-bar" id="progressBar" style="width: 0%"></div>
            <div class="progress-text" id="progressText">ÉTAPE 0 / 6</div>
        </div>
        <p class="progress-hint">&#128161; Cliquez sur les cadenas pour débloquer les étapes pendant votre live coding !</p>
    </section>

    <!-- CRUD Stats -->
    <div class="crud-stats">
        <div class="stat-card">
            <div class="stat-icon">&#128209;</div>
            <div class="stat-label">Migrations</div>
            <div class="stat-value" id="statMigrations">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">&#10133;</div>
            <div class="stat-label">Create</div>
            <div class="stat-value" id="statCreate">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">&#128065;</div>
            <div class="stat-label">Read</div>
            <div class="stat-value" id="statRead">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">&#9998;</div>
            <div class="stat-label">Update</div>
            <div class="stat-value" id="statUpdate">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">&#128465;</div>
            <div class="stat-label">Delete</div>
            <div class="stat-value" id="statDelete">0</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">&#11088;</div>
            <div class="stat-label">Complété</div>
            <div class="stat-value" id="statComplete">0%</div>
        </div>
    </div>

    <div class="quest-grid" id="questGrid"></div>
</div>

<button class="reset-btn" id="resetBtn" title="Réinitialiser toute la progression">&#128260; Reset</button>

<script>
    const questLevels = [
        {
            level: 1,
            title: "Migration: La Base",
            description: "Créer la table 'products' avec les colonnes essentielles",
            badgeType: "migration",
            badgeText: "&#128209; Migration",
            code: [
                "php artisan make:migration create_products_table",
                "",
                "Schema::create('products', function (Blueprint $table) {",
                "    $table->id();",
                "    $table->string('name');",
                "    $table->decimal('price', 8, 2);",
                "    $table->integer('stock');",
                "    $table->timestamps();",
                "});"
            ],
            stats: [
                { icon: "&#128209;", text: "Structure de données" },
                { icon: "&#128295;", text: "Schema Builder" },
                { icon: "&#127919;", text: "Migration Laravel" }
            ],
            href: "/crud-quest/step-1-migration",
            buttonText: "Commencer"
        },
        {
            level: 2,
            title: "Create: Insertion",
            description: "Ajouter des produits dans la base de données",
            badgeType: "create",
            badgeText: "&#10133; Create",
            code: [
                "$validated = $request->validate([",
                "'name' => 'required', 'price' => 'required|numeric', 'stock' => 'required|integer']);",
                "",
                "Product::create([...]);"
            ],
            stats: [
                { icon: "&#10133;", text: "Insertion de données" },
                { icon: "&#128190;", text: "Eloquent ORM" },
                { icon: "&#127919;", text: "Mass Assignment" }
            ],
            href: "/crud-quest/step-2-create",
            buttonText: "Niveau Verrouillé"
        },
        {
            level: 3,
            title: "Read: Lecture",
            description: "Récupérer et afficher les produits",
            badgeType: "read",
            badgeText: "&#128065; Read",
            code: [
                "// Tous les produits",
                "$products = Product::all();",
                "",
                "// Un produit spécifique",
                "$product = Product::find(1);",
                "",
                "// Avec conditions",
                "$products = Product::where('stock', '>', 0)->get();"
            ],
            stats: [
                { icon: "&#128065;", text: "Récupération de données" },
                { icon: "&#128269;", text: "Query Builder" },
                { icon: "&#127919;", text: "Collections" }
            ],
            href: "/crud-quest/step-3-read",
            buttonText: "Niveau Verrouillé"
        },
        {
            level: 4,
            title: "Update: Modification",
            description: "Mettre à jour les produits existants",
            badgeType: "update",
            badgeText: "&#9998; Update",
            code: [
                "$product = Product::find(1);",
                "$product->price = 899.99;",
                "$product->stock = 45;",
                "$product->save();",
                "",
                "// Ou avec update()",
                "Product::where('id', 1)->update([...]);"
            ],
            stats: [
                { icon: "&#9998;", text: "Modification de données" },
                { icon: "&#128260;", text: "Mise à jour" },
                { icon: "&#127919;", text: "Eloquent Update" }
            ],
            href: "/crud-quest/step-4-update",
            buttonText: "Niveau Verrouillé"
        },
        {
            level: 5,
            title: "Delete: Suppression",
            description: "Supprimer des produits de la base",
            badgeType: "delete",
            badgeText: "&#128465; Delete",
            code: [
                "$product = Product::find(1);",
                "$product->delete();",
                "",
                "// Ou directement",
                "Product::destroy(1);",
                "",
                "// Suppression multiple",
                "Product::destroy([1, 2, 3]);"
            ],
            stats: [
                { icon: "&#128465;", text: "Suppression de données" },
                { icon: "&#9888;", text: "Opération critique" },
                { icon: "&#127919;", text: "Soft Delete possible" }
            ],
            href: "/crud-quest/step-5-delete",
            buttonText: "Niveau Verrouillé"
        },
        {
            level: 6,
            title: "CRUD Master: Système Complet",
            description: "Application CRUD complète avec interface interactive",
            badgeType: "master",
            badgeText: "&#11088; CRUD Master",
            code: [
                "// Controller complet",
                "public function index() { return view('products.index'); }",
                "public function create() { return view('products.create'); }",
                "public function store(Request $request) { ... }",
                "public function show($id) { ... }",
                "public function edit($id) { ... }",
                "public function update(Request $request, $id) { ... }",
                "public function destroy($id) { ... }"
            ],
            stats: [
                { icon: "&#11088;", text: "Application complète" },
                { icon: "&#128640;", text: "Production ready" },
                { icon: "&#127919;", text: "Maîtrise CRUD" }
            ],
            href: "/crud-quest/step-6-complete",
            buttonText: "Niveau Verrouillé"
        }
    ];

    let unlockedLevels = JSON.parse(localStorage.getItem('laravelCrudProgress') || '[]');

    function saveProgress() {
        localStorage.setItem('laravelCrudProgress', JSON.stringify(unlockedLevels));
    }

    function updateProgressBar() {
        const progress = (unlockedLevels.length / 6) * 100;
        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('progressText').textContent = `ÉTAPE ${unlockedLevels.length} / 6`;
    }

    function updateStats() {
        const migrations = unlockedLevels.includes(1) ? 1 : 0;
        const create = unlockedLevels.includes(2) ? 1 : 0;
        const read = unlockedLevels.includes(3) ? 1 : 0;
        const update = unlockedLevels.includes(4) ? 1 : 0;
        const deleteOp = unlockedLevels.includes(5) ? 1 : 0;
        const complete = Math.round((unlockedLevels.length / 6) * 100);

        document.getElementById('statMigrations').textContent = migrations;
        document.getElementById('statCreate').textContent = create;
        document.getElementById('statRead').textContent = read;
        document.getElementById('statUpdate').textContent = update;
        document.getElementById('statDelete').textContent = deleteOp;
        document.getElementById('statComplete').textContent = complete + '%';
    }

    function createParticles(card, color) {
        const particlesContainer = document.createElement('div');
        particlesContainer.className = 'particles';
        card.appendChild(particlesContainer);

        for (let i = 0; i < 12; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.background = color;
            particle.style.left = '50%';
            particle.style.top = '50%';
            particle.style.setProperty('--tx', (Math.random() - 0.5) * 200 + 'px');
            particle.style.setProperty('--ty', (Math.random() - 0.5) * 200 + 'px');
            particle.style.animationDelay = Math.random() * 0.2 + 's';
            particlesContainer.appendChild(particle);
        }

        setTimeout(() => particlesContainer.remove(), 1200);
    }

    function createQuestCard(quest, index) {
        const isUnlocked = unlockedLevels.includes(quest.level);
        const card = document.createElement('div');
        card.className = `quest-card ${isUnlocked ? 'unlocked' : ''}`;
        card.style.animation = `slide-in 0.6s ease-out ${index * 0.1}s both`;
        card.dataset.level = quest.level;

        card.innerHTML = `
            <button class="lock-btn" title="Cliquer pour (de)verrouiller cette étape">
                <span class="lock-icon">${isUnlocked ? '&#128275;' : '&#128274;'}</span>
            </button>
            <div class="quest-header">
                <div class="quest-level">${String(quest.level).padStart(2, '0')}</div>
                <div class="quest-info">
                    <h2 class="quest-title">${quest.title}</h2>
                    <p class="quest-description">${quest.description}</p>
                    <span class="badge badge-${quest.badgeType}">${quest.badgeText}</span>
                </div>
            </div>
            <div class="code-block">
                <code>${quest.code.join('\n')}</code>
            </div>
            <div class="quest-stats">
                ${quest.stats.map(stat => `
                    <div class="stat-item">
                        <span class="stat-icon">${stat.icon}</span>
                        <span>${stat.text}</span>
                    </div>
                `).join('')}
            </div>
            <a href="${quest.href}" class="quest-btn">
                &#8594; ${isUnlocked ? 'Accéder à l\'étape' : quest.buttonText} &#8592;
            </a>
        `;

        const lockBtn = card.querySelector('.lock-btn');
        const lockIcon = card.querySelector('.lock-icon');
        const questLevel = card.querySelector('.quest-level');
        const badge = card.querySelector('.badge');
        const codeBlock = card.querySelector('.code-block');
        const questBtn = card.querySelector('.quest-btn');
        const statItems = card.querySelectorAll('.stat-item');

        let isAnimating = false;

        lockBtn.addEventListener('click', function(e) {
            e.preventDefault();

            if (isAnimating) return;
            isAnimating = true;

            const currentlyUnlocked = unlockedLevels.includes(quest.level);

            lockBtn.classList.add('shaking');

            if (currentlyUnlocked) {
                lockBtn.classList.add('glowing-lock');
                card.classList.add('animating-lock');

                setTimeout(() => {
                    lockIcon.innerHTML = '&#128274;';
                    lockBtn.classList.add('bouncing');
                }, 300);

                setTimeout(() => {
                    unlockedLevels = unlockedLevels.filter(l => l !== quest.level);
                    saveProgress();
                    updateProgressBar();
                    updateStats();

                    card.classList.remove('unlocked');
                    questBtn.innerHTML = `&#8594; ${quest.buttonText} &#8592;`;
                }, 400);

                setTimeout(() => {
                    lockBtn.classList.remove('shaking', 'glowing-lock', 'bouncing');
                    card.classList.remove('animating-lock');
                    isAnimating = false;
                }, 700);

            } else {
                lockBtn.classList.add('glowing-unlock');
                card.classList.add('animating-unlock');

                setTimeout(() => {
                    lockIcon.innerHTML = '&#128275;';
                    lockBtn.classList.add('bouncing');
                    createParticles(card, '#8A2BE2');
                }, 400);

                setTimeout(() => {
                    questLevel.classList.add('pop');
                    codeBlock.classList.add('glow');
                }, 500);

                setTimeout(() => {
                    badge.classList.add('pulse');
                }, 600);

                setTimeout(() => {
                    statItems.forEach((item, i) => {
                        setTimeout(() => item.classList.add('highlight'), i * 80);
                    });
                }, 650);

                setTimeout(() => {
                    questBtn.classList.add('reveal');
                }, 800);

                setTimeout(() => {
                    unlockedLevels.push(quest.level);
                    unlockedLevels.sort((a, b) => a - b);
                    saveProgress();
                    updateProgressBar();
                    updateStats();

                    card.classList.add('unlocked');
                    questBtn.innerHTML = `&#8594; Accéder à l'étape &#8592;`;
                }, 500);

                setTimeout(() => {
                    lockBtn.classList.remove('shaking', 'glowing-unlock', 'bouncing');
                    card.classList.remove('animating-unlock');
                    questLevel.classList.remove('pop');
                    badge.classList.remove('pulse');
                    codeBlock.classList.remove('glow');
                    statItems.forEach(item => item.classList.remove('highlight'));
                    questBtn.classList.remove('reveal');
                    isAnimating = false;
                }, 1100);
            }
        });

        return card;
    }

    function renderQuests() {
        const grid = document.getElementById('questGrid');
        grid.innerHTML = '';
        questLevels.forEach((quest, index) => {
            grid.appendChild(createQuestCard(quest, index));
        });
        updateProgressBar();
        updateStats();
    }

    document.getElementById('resetBtn').addEventListener('click', function() {
        if (confirm('Réinitialiser toute la progression CRUD ?')) {
            unlockedLevels = [];
            saveProgress();
            renderQuests();
        }
    });

    // ==================== INTERACTIVE TITLE ====================
    const mainTitle = document.getElementById('mainTitle');
    let mouseX = 0;
    let mouseY = 0;
    let titleRect = mainTitle.getBoundingClientRect();

    window.addEventListener('resize', () => {
        titleRect = mainTitle.getBoundingClientRect();
    });

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;

        const titleCenterX = titleRect.left + titleRect.width / 2;
        const titleCenterY = titleRect.top + titleRect.height / 2;

        const deltaX = (mouseX - titleCenterX) / window.innerWidth;
        const deltaY = (mouseY - titleCenterY) / window.innerHeight;

        const transformX = deltaX * 10;
        const transformY = deltaY * 10;

        mainTitle.style.transform = `translate(${transformX}px, ${transformY}px)`;
    });

    mainTitle.addEventListener('click', () => {
        mainTitle.style.animation = 'none';
        setTimeout(() => {
            mainTitle.style.animation = 'title-glitch 0.5s ease-out';
        }, 10);
    });

    // ==================== DATABASE PARTICLES ====================
    function createDatabaseParticles() {
        const container = document.getElementById('dbParticles');
        const icons = ['&#128190;', '&#128209;', '&#128202;', '&#128200;', '&#128196;'];

        for (let i = 0; i < 10; i++) {
            const particle = document.createElement('div');
            particle.className = 'db-particle';
            particle.innerHTML = icons[Math.floor(Math.random() * icons.length)];
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (10 + Math.random() * 10) + 's';
            container.appendChild(particle);
        }
    }

    createDatabaseParticles();
    renderQuests();
</script>
</body>
</html>
