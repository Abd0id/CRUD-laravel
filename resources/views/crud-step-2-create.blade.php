<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Quest - Étape 2: Create</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4CAF50;
            --secondary: #388E3C;
            --accent: #81C784;
            --dark: #0A0A14;
            --dark-card: #0F1F0F;
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
            0%, 100% { transform: scale(1); box-shadow: 0 0 0 rgba(76, 175, 80, 0); }
            50% { transform: scale(1.05); box-shadow: 0 0 20px rgba(76, 175, 80, 0.5); }
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

        .two-columns {
            display: grid;
            gap: 2rem;
            grid-template-columns: 1fr;
        }

        @media (min-width: 968px) {
            .two-columns {
                grid-template-columns: 1fr 1fr;
            }
        }

        .info-card {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 2rem;
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
            margin-bottom: 1.5rem;
        }

        .info-card p {
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .code-block {
            background: #000;
            border: 2px solid var(--primary);
            border-radius: 4px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            font-family: 'Space Mono', monospace;
            overflow-x: auto;
            box-shadow: 0 0 20px rgba(76, 175, 80, 0.3);
        }

        .code-block pre {
            color: var(--primary);
            line-height: 1.8;
        }

        .comment {
            color: #888;
        }

        .keyword {
            color: #81C784;
        }

        .string {
            color: #FFD54F;
        }

        /* Interactive Form */
        .interactive-form {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 2rem;
        }

        .interactive-form h3 {
            font-family: 'Press Start 2P', cursive;
            font-size: 0.9rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--accent);
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            background: #000;
            border: 2px solid var(--primary);
            border-radius: 4px;
            color: var(--text);
            font-family: 'Space Mono', monospace;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 15px rgba(76, 175, 80, 0.5);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 0 var(--secondary);
        }

        .submit-btn:hover {
            background: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 6px 0 var(--secondary), 0 0 20px var(--primary);
        }

        .submit-btn:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 var(--secondary);
        }

        .submit-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Products List */
        .products-list {
            margin-top: 2rem;
        }

        .product-item {
            background: rgba(76, 175, 80, 0.1);
            border: 1px solid var(--primary);
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
            animation: productAppear 0.5s ease-out;
        }

        @keyframes productAppear {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .product-item h4 {
            color: var(--accent);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .product-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .product-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            opacity: 0.5;
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
        }

        .success-message {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid var(--primary);
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
            animation: slideIn 0.5s ease-out;
            display: none;
        }

        .success-message.show {
            display: block;
        }

        .method-comparison {
            display: grid;
            gap: 1rem;
            margin: 2rem 0;
        }

        @media (min-width: 768px) {
            .method-comparison {
                grid-template-columns: 1fr 1fr;
            }
        }

        .method-card {
            background: rgba(76, 175, 80, 0.1);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 1.5rem;
        }

        .method-card h3 {
            color: var(--accent);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .method-card ul {
            margin-left: 1.5rem;
            line-height: 1.8;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="step-badge">ÉTAPE 2 - CREATE ➕</div>

        <h1 class="title">Insérer des Données</h1>
        <p class="subtitle">Ajouter des produits à la base de données</p>

        <div class="two-columns">
            <!-- Left Column: Theory -->
            <div>
                <div class="info-card">
                    <h2>🎯 L'opération CREATE</h2>
                    <p>Le <strong>C</strong> de CRUD signifie <strong>Create</strong> (Créer). C'est l'opération qui permet d'insérer de nouvelles données dans votre base.</p>
                    <p>Laravel offre plusieurs façons d'insérer des données avec Eloquent ORM :</p>
                </div>

                <div class="method-comparison">
                    <div class="method-card">
                        <h3>Méthode 1: Save()</h3>
                        <ul>
                            <li>Instancier le modèle</li>
                            <li>Définir les propriétés</li>
                            <li>Appeler save()</li>
                            <li>Plus verbeux mais clair</li>
                        </ul>
                    </div>
                    <div class="method-card">
                        <h3>Méthode 2: Create()</h3>
                        <ul>
                            <li>Insertion en une ligne</li>
                            <li>Passe un tableau</li>
                            <li>Nécessite $fillable</li>
                            <li>Plus concis</li>
                        </ul>
                    </div>
                </div>

                <div class="code-block">
                    <pre><span class="comment">// Méthode 1: Avec save()</span>
<span class="keyword">$product</span> = <span class="keyword">new</span> Product();
<span class="keyword">$product</span>->name = <span class="string">'Laptop Dell XPS'</span>;
<span class="keyword">$product</span>->description = <span class="string">'Ordinateur portable haute performance'</span>;
<span class="keyword">$product</span>->price = <span class="string">1299.99</span>;
<span class="keyword">$product</span>->stock = <span class="string">15</span>;
<span class="keyword">$product</span>-><span class="keyword">save()</span>;

<span class="comment">// Méthode 2: Avec create() - Plus rapide</span>
<span class="keyword"> public function </span>step2() {
    <span class="string">$products </span>= <span class="string">Product::latest()->take(5)->get();</span>,
    <span class="string">return</span> view('crud-step-2-create', compact('products'));
    },
]);
    <span class="string">public</span> function store(Request $request) {
        <span class="string">$validated</span> = <span class="string">$request->validate</span>([
            <span class="string">'name'</span> => <span class="string">'required'</span>, <span class="string">'price'</span> => <span class="string">'required|numeric'</span>, <span class="string">'stock'</span> => <span class="string">'required|integer'</span>
        ]);
        <span class="string">Product</span>::<span class="string">create($validated)</span>;
        <span class="string">return</span> redirect()->back()->with('success', 'Produit créé !');
    }

<span class="comment">// ⚠️ Important: Définir $fillable dans le modèle</span>
<span class="comment">// app/Models/Product.php</span>
<span class="keyword">protected</span> $fillable = [
    <span class="string">'name'</span>, <span class="string">'description'</span>, <span class="string">'price'</span>, <span class="string">'stock'</span>
];</pre>
                </div>

                <div class="info-card" style="margin-top: 2rem;">
                    <h2>🛡️ Mass Assignment Protection</h2>
                    <p>Par défaut, Laravel protège contre l'affectation de masse (mass assignment). Vous devez définir quels champs peuvent être remplis avec <code>$fillable</code> ou exclure certains champs avec <code>$guarded</code>.</p>
                    <div class="code-block">
                        <pre><span class="comment">// Option 1: Autoriser certains champs</span>
<span class="keyword">protected</span> $fillable = [<span class="string">'name'</span>, <span class="string">'price'</span>, <span class="string">'stock'</span>];

<span class="comment">// Option 2: Protéger certains champs</span>
<span class="keyword">protected</span> $guarded = [<span class="string">'id'</span>, <span class="string">'created_at'</span>];

<span class="comment">// Option 3: Tout autoriser (⚠️ Non recommandé)</span>
<span class="keyword">protected</span> $guarded = [];</pre>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Demo -->
            <div>
                <div class="interactive-form">
                    <h3>🎮 Mode: Database Réel</h3>

                    @if(session('success'))
                        <div class="success-message show" style="background: rgba(76, 175, 80, 0.2); border: 2px solid var(--primary); padding: 1rem; margin-bottom: 1rem;">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="error-message" style="background: rgba(255, 0, 0, 0.2); border: 2px solid #ff0000; padding: 1rem; margin-bottom: 1rem;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form id="createForm" action="{{ route('products.store') }}" method="POST">
                        @csrf <div class="form-group">
                            <label for="name">Nom du produit *</label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Prix (€) *</label>
                            <input type="number" name="price" id="price" step="0.01" required value="{{ old('price') }}">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock *</label>
                            <input type="number" name="stock" id="stock" required value="{{ old('stock') }}">
                        </div>
                        <button type="submit" class="submit-btn">➕ Ajouter le produit</button>
                    </form>
                </div>

                <div class="products-list">
                    <h3 style="font-family: 'Press Start 2P', cursive; font-size: 0.9rem; color: var(--accent); margin-bottom: 1rem;">
                        📦 Produits en Base de Données ({{ $products->count() }})
                    </h3>
                    <div id="productsList">
                        @forelse($products as $product)
                            <div class="product-item">
                                <h4>{{ $product->name }}</h4>
                                <p style="margin-bottom: 0.5rem; opacity: 0.8;">{{ $product->description }}</p>
                                <div class="product-meta">
                                    <span>💰 {{ number_format($product->price, 2) }} €</span>
                                    <span>📦 Stock: {{ $product->stock }}</span>
                                    <span>🆔 ID: {{ $product->id }}</span>
                                    <span>📅 {{ $product->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                                <p>La base de données est vide.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="button-group">
            <a href="/crud-quest/step-1-migration" class="button secondary">← Étape 1: Migration</a>
            <a href="/crud-quest/step-3-read" class="button primary">→ Étape 3: Read</a>
        </div>
    </div>

</body>
</html>
