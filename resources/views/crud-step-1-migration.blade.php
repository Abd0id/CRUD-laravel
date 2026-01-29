<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Quest - Étape 1: Migration</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #9C27B0;
            --secondary: #7B1FA2;
            --accent: #BA68C8;
            --dark: #0A0A14;
            --dark-card: #1A0F2E;
            --text: #E0E0E0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Space Mono', monospace;
            background: var(--dark);
            color: var(--text);
            min-height: 100vh;
            padding: 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .step-badge {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
            margin-bottom: 2rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .title {
            font-family: 'Press Start 2P', cursive;
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            color: var(--primary);
            margin-bottom: 1rem;
            line-height: 1.5;
            text-shadow: 0 0 20px var(--primary);
        }

        .subtitle {
            font-size: 1.2rem;
            color: var(--accent);
            margin-bottom: 3rem;
        }

        .info-card {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            animation: slideIn 0.6s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .info-card h2 {
            font-family: 'Press Start 2P', cursive;
            font-size: 1rem;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .info-card p {
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .steps-container {
            display: grid;
            gap: 1rem;
            margin: 2rem 0;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
            background: rgba(156, 39, 176, 0.1);
            border-left: 3px solid var(--primary);
            transition: all 0.3s ease;
        }

        .step-item:hover {
            background: rgba(156, 39, 176, 0.2);
            transform: translateX(10px);
        }

        .step-number {
            font-family: 'Press Start 2P', cursive;
            font-size: 1.5rem;
            color: var(--primary);
            min-width: 40px;
        }

        .code-block {
            background: #000;
            border: 2px solid var(--primary);
            border-radius: 4px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            font-family: 'Space Mono', monospace;
            overflow-x: auto;
            box-shadow: 0 0 20px rgba(156, 39, 176, 0.3);
        }

        .code-block pre {
            color: var(--primary);
            line-height: 1.8;
        }

        .comment {
            color: #888;
        }

        .keyword {
            color: #BA68C8;
        }

        .string {
            color: #81C784;
        }

        /* Table Visualization */
        .table-visual {
            background: var(--dark-card);
            border: 2px solid var(--accent);
            border-radius: 8px;
            padding: 2rem;
            margin: 2rem 0;
        }

        .table-visual h3 {
            font-family: 'Press Start 2P', cursive;
            font-size: 0.9rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .table-schema {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #000;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border: 1px solid var(--primary);
        }

        th {
            background: var(--primary);
            color: white;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
        }

        td {
            font-size: 0.9rem;
        }

        .type-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background: rgba(156, 39, 176, 0.3);
            border-radius: 4px;
            font-size: 0.8rem;
            color: var(--accent);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 3rem;
            flex-wrap: wrap;
        }

        .button {
            display: inline-block;
            padding: 1rem 2rem;
            text-decoration: none;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.8rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.3);
        }

        .button.primary {
            background: var(--primary);
            color: white;
        }

        .button.secondary {
            background: transparent;
            border: 2px solid var(--text);
            color: var(--text);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.3);
        }

        .warning-box {
            background: rgba(255, 152, 0, 0.1);
            border: 2px solid #FF9800;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
        }

        .warning-box h3 {
            color: #FF9800;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .tip-box {
            background: rgba(76, 175, 80, 0.1);
            border: 2px solid #4CAF50;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
        }

        .tip-box h3 {
            color: #4CAF50;
            margin-bottom: 1rem;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="step-badge">ÉTAPE 1 - MIGRATION 🗂️</div>
        
        <h1 class="title">La Base de Données</h1>
        <p class="subtitle">Créer la structure de votre table products</p>

        <div class="info-card">
            <h2>🎯 Objectif</h2>
            <p>Les migrations sont comme un <strong>système de versionnement pour votre base de données</strong>. Elles vous permettent de définir et partager la structure de votre base de données avec votre équipe.</p>
            <p>Dans cette étape, vous allez créer la table <code>products</code> qui servira de base pour toutes les opérations CRUD.</p>
        </div>

        <div class="steps-container">
            <div class="step-item">
                <div class="step-number">01</div>
                <div>
                    <h3 style="color: var(--accent); margin-bottom: 0.5rem;">Générer la migration</h3>
                    <p>Utilisez Artisan pour créer le fichier de migration</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-number">02</div>
                <div>
                    <h3 style="color: var(--accent); margin-bottom: 0.5rem;">Définir la structure</h3>
                    <p>Ajoutez les colonnes nécessaires dans la méthode up()</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-number">03</div>
                <div>
                    <h3 style="color: var(--accent); margin-bottom: 0.5rem;">Exécuter la migration</h3>
                    <p>Lancez la migration pour créer la table dans la base</p>
                </div>
            </div>
        </div>

        <div class="code-block">
            <pre><span class="comment">// Étape 1: Créer la migration</span>
<span class="keyword">php artisan make:migration</span> <span class="string">create_products_table</span>

<span class="comment">// Étape 2: Ouvrir le fichier dans database/migrations/</span>
<span class="comment">// xxxx_xx_xx_xxxxxx_create_products_table.php</span>

<span class="keyword">use</span> Illuminate\Database\Migrations\Migration;
<span class="keyword">use</span> Illuminate\Database\Schema\Blueprint;
<span class="keyword">use</span> Illuminate\Support\Facades\Schema;

<span class="keyword">return new class extends</span> Migration
{
    <span class="keyword">public function</span> up(): void
    {
        Schema::<span class="keyword">create</span>(<span class="string">'products'</span>, <span class="keyword">function</span> (Blueprint $table) {
            $table-><span class="keyword">id</span>();                           <span class="comment">// ID auto-incrémenté</span>
            $table-><span class="keyword">string</span>(<span class="string">'name'</span>);                  <span class="comment">// Nom du produit</span>
            $table-><span class="keyword">text</span>(<span class="string">'description'</span>)-><span class="keyword">nullable</span>(); <span class="comment">// Description (optionnel)</span>
            $table-><span class="keyword">decimal</span>(<span class="string">'price'</span>, 8, 2);         <span class="comment">// Prix (8 chiffres, 2 décimales)</span>
            $table-><span class="keyword">integer</span>(<span class="string">'stock'</span>)-><span class="keyword">default</span>(0);    <span class="comment">// Stock disponible</span>
            $table-><span class="keyword">timestamps</span>();                  <span class="comment">// created_at & updated_at</span>
        });
    }

    <span class="keyword">public function</span> down(): void
    {
        Schema::<span class="keyword">dropIfExists</span>(<span class="string">'products'</span>);
    }
};

<span class="comment">// Étape 3: Exécuter la migration</span>
<span class="keyword">php artisan migrate</span></pre>
        </div>

        <div class="table-visual">
            <h3>📊 Structure de la table "products"</h3>
            <div class="table-schema">
                <table>
                    <thead>
                        <tr>
                            <th>Colonne</th>
                            <th>Type</th>
                            <th>Attributs</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>id</td>
                            <td><span class="type-badge">BIGINT UNSIGNED</span></td>
                            <td>PRIMARY KEY, AUTO_INCREMENT</td>
                            <td>Identifiant unique</td>
                        </tr>
                        <tr>
                            <td>name</td>
                            <td><span class="type-badge">VARCHAR(255)</span></td>
                            <td>NOT NULL</td>
                            <td>Nom du produit</td>
                        </tr>
                        <tr>
                            <td>description</td>
                            <td><span class="type-badge">TEXT</span></td>
                            <td>NULLABLE</td>
                            <td>Description détaillée</td>
                        </tr>
                        <tr>
                            <td>price</td>
                            <td><span class="type-badge">DECIMAL(8,2)</span></td>
                            <td>NOT NULL</td>
                            <td>Prix du produit</td>
                        </tr>
                        <tr>
                            <td>stock</td>
                            <td><span class="type-badge">INTEGER</span></td>
                            <td>DEFAULT 0</td>
                            <td>Quantité en stock</td>
                        </tr>
                        <tr>
                            <td>created_at</td>
                            <td><span class="type-badge">TIMESTAMP</span></td>
                            <td>NULLABLE</td>
                            <td>Date de création</td>
                        </tr>
                        <tr>
                            <td>updated_at</td>
                            <td><span class="type-badge">TIMESTAMP</span></td>
                            <td>NULLABLE</td>
                            <td>Date de modification</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tip-box">
            <h3>💡 Bonnes Pratiques</h3>
            <ul style="margin-left: 2rem; line-height: 1.8;">
                <li>Utilisez <code>timestamps()</code> pour tracker les créations/modifications</li>
                <li>Définissez des <code>default()</code> pour éviter les valeurs NULL</li>
                <li>Utilisez <code>nullable()</code> pour les champs optionnels</li>
                <li>Pensez aux index pour les colonnes souvent recherchées</li>
                <li>La méthode <code>down()</code> permet de rollback la migration</li>
            </ul>
        </div>

        <div class="warning-box">
            <h3>⚠️ Important</h3>
            <p><strong>Ne modifiez jamais une migration déjà exécutée en production !</strong></p>
            <p>Créez plutôt une nouvelle migration pour modifier la table :</p>
            <div class="code-block" style="margin-top: 1rem;">
                <pre><span class="keyword">php artisan make:migration</span> <span class="string">add_category_to_products_table</span></pre>
            </div>
        </div>

        <div class="info-card">
            <h2>🔄 Commandes utiles</h2>
            <div class="code-block">
                <pre><span class="comment"># Exécuter toutes les migrations</span>
<span class="keyword">php artisan migrate</span>

<span class="comment"># Annuler la dernière migration</span>
<span class="keyword">php artisan migrate:rollback</span>

<span class="comment"># Réinitialiser et relancer toutes les migrations</span>
<span class="keyword">php artisan migrate:fresh</span>

<span class="comment"># Voir le statut des migrations</span>
<span class="keyword">php artisan migrate:status</span></pre>
            </div>
        </div>

        <div class="button-group">
            <a href="/crud-quest" class="button secondary">← Menu principal</a>
            <a href="/crud-quest/step-2-create" class="button primary">→ Étape 2: Create</a>
        </div>
    </div>
</body>
</html>
