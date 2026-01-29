<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Quest - Étape 3: Read</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Space+Mono:wght@400;700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --primary: #2196F3;
            --secondary: #1976D2;
            --accent: #64B5F6;
            --dark: #0A0A14;
            --dark-card: #0F1520;
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
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 0 0 rgba(33, 150, 243, 0);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 20px rgba(33, 150, 243, 0.5);
            }
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
            box-shadow: 0 0 20px rgba(33, 150, 243, 0.3);
        }

        .code-block pre {
            color: var(--primary);
            line-height: 1.8;
        }

        .comment {
            color: #888;
        }

        .keyword {
            color: #64B5F6;
        }

        .string {
            color: #FFD54F;
        }

        /* Search and Filter */
        .search-bar {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem;
            background: #000;
            border: 2px solid var(--primary);
            border-radius: 4px;
            color: var(--text);
            font-family: 'Space Mono', monospace;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 15px rgba(33, 150, 243, 0.5);
        }

        .filter-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            background: rgba(33, 150, 243, 0.2);
            border: 2px solid var(--primary);
            border-radius: 4px;
            color: var(--text);
            font-family: 'Space Mono', monospace;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary);
            color: white;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            margin-bottom: 2rem;
        }

        .product-card {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            animation: cardAppear 0.5s ease-out;
        }

        @keyframes cardAppear {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .product-card:hover {
            border-color: var(--accent);
            box-shadow: 0 0 20px rgba(33, 150, 243, 0.3);
            transform: translateY(-5px);
        }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .product-id {
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-family: 'Press Start 2P', cursive;
        }

        .product-card h3 {
            color: var(--accent);
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .product-description {
            opacity: 0.8;
            margin-bottom: 1rem;
            line-height: 1.6;
            min-height: 3rem;
        }

        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid var(--primary);
        }

        .product-price {
            font-size: 1.3rem;
            color: var(--accent);
            font-weight: bold;
        }

        .product-stock {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stock-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        .stock-badge.in-stock {
            background: rgba(76, 175, 80, 0.3);
            color: #4CAF50;
        }

        .stock-badge.low-stock {
            background: rgba(255, 152, 0, 0.3);
            color: #FF9800;
        }

        .stock-badge.out-of-stock {
            background: rgba(244, 67, 54, 0.3);
            color: #F44336;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            opacity: 0.5;
        }

        .empty-state svg {
            width: 100px;
            height: 100px;
            margin-bottom: 1rem;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: rgba(33, 150, 243, 0.1);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            color: var(--accent);
            font-weight: bold;
            font-family: 'Press Start 2P', cursive;
        }

        .stat-label {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-top: 0.5rem;
        }

        .methods-grid {
            display: grid;
            gap: 1rem;
            margin: 2rem 0;
        }

        @media (min-width: 768px) {
            .methods-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .method-card {
            background: rgba(33, 150, 243, 0.1);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 1.5rem;
        }

        .method-card h3 {
            color: var(--accent);
            margin-bottom: 1rem;
            font-size: 1rem;
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
    <div class="step-badge">ÉTAPE 3 - READ 👁️</div>

    <h1 class="title">Lire les Données</h1>
    <p class="subtitle">Récupérer et afficher les produits</p>

    <div class="info-card">
        <h2>🎯 L'opération READ</h2>
        <p>Le <strong>R</strong> de CRUD signifie <strong>Read</strong> (Lire). Cette opération permet de récupérer des
            données depuis la base.</p>
        <p>Laravel Eloquent offre de nombreuses méthodes pour interroger la base de données de manière élégante et
            expressive.</p>
    </div>

    <div class="methods-grid">
        <div class="method-card">
            <h3>📋 Récupération simple</h3>
            <div class="code-block">
                    <pre>public function step3(Request $request) {
    $query = Product::query();
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    $products = $query->get();
    return view('crud-step-3-read', compact('products'));
}</pre>
            </div>
        </div>

        <div class="method-card">
            <h3>🔍 Avec conditions</h3>
            <div class="code-block">
                    <pre><span class="comment">// Produits en stock</span>
<span class="keyword">$products</span> = Product::<span class="keyword">where</span>(<span class="string">'stock'</span>, <span
                            class="string">'>'</span>, <span class="string">0</span>)
    -><span class="keyword">get()</span>;

<span class="comment">// Prix entre 100 et 1000</span>
<span class="keyword">$products</span> = Product::<span class="keyword">whereBetween</span>(
    <span class="string">'price'</span>, [<span class="string">100</span>, <span class="string">1000</span>]
)-><span class="keyword">get()</span>;</pre>
            </div>
        </div>

        <div class="method-card">
            <h3>🔤 Recherche</h3>
            <div class="code-block">
                    <pre><span class="comment">// Recherche par nom</span>
<span class="keyword">$products</span> = Product::<span class="keyword">where</span>(
    <span class="string">'name'</span>, <span class="string">'LIKE'</span>, <span class="string">'%laptop%'</span>
)-><span class="keyword">get()</span>;

<span class="comment">// Première occurrence</span>
<span class="keyword">$product</span> = Product::<span class="keyword">where</span>(<span class="string">'name'</span>, <span
                            class="string">'iPhone'</span>)
    -><span class="keyword">first()</span>;</pre>
            </div>
        </div>

        <div class="method-card">
            <h3>📊 Tri et limitation</h3>
            <div class="code-block">
                    <pre><span class="comment">// Tri croissant</span>
<span class="keyword">$products</span> = Product::<span class="keyword">orderBy</span>(<span
                            class="string">'price'</span>)
    -><span class="keyword">get()</span>;

<span class="comment">// Les 5 plus récents</span>
<span class="keyword">$products</span> = Product::<span class="keyword">latest()</span>
    -><span class="keyword">take</span>(<span class="string">5</span>)-><span class="keyword">get()</span>;</pre>
            </div>
        </div>
    </div>



    <!-- Search Bar -->
    <form class="search-bar" action="{{ route('products.read') }}" method="GET">
        <input
            type="text"
            name="search"
            class="search-input"
            id="searchInput"
            placeholder="🔍 Rechercher un produit par nom..."
        >
        <div class="filter-buttons">
            <button class="filter-btn active" type="submit" data-filter="all">Tous</button>
            <button class="filter-btn" data-filter="in-stock">En stock</button>
            <button class="filter-btn" data-filter="low-stock">Stock faible</button>
            <button class="filter-btn" data-filter="expensive">Prix > 500€</button>
        </div>
    </form>

    <!-- Products Grid -->
    <div class="products-grid" id="productsGrid">
        @forelse($products as $product)
            <div class="product-card">
                <div class="product-header">
                    <span class="product-id">#{{ $product->id }}</span>
                </div>
                <h3>{{ $product->name }}</h3>
                <p class="product-description">
                    {{ $product->description ?? 'Pas de description' }}
                </p>
                <div class="product-footer">
                    <div class="product-price">{{ number_format($product->price, 2) }}€</div>
                    <div class="product-stock">
                        @if($product->stock <= 0)
                            <span class="stock-badge out-of-stock">Rupture</span>
                        @elseif($product->stock < 10)
                            <span class="stock-badge low-stock">{{ $product->stock }} restants</span>
                        @else
                            <span class="stock-badge in-stock">{{ $product->stock }} en stock</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column: 1 / -1;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">🔍</div>
                <p>La base de données est vide</p>
                <p style="font-size: 0.9rem; opacity: 0.7;">Allez à l'étape 2 pour ajouter des données.</p>
            </div>
        @endforelse
    </div>

    <div class="button-group">
        <a href="/crud-quest/step-2-create" class="button secondary">← Étape 2: Create</a>
        <a href="/crud-quest/step-4-update" class="button primary">→ Étape 4: Update</a>
    </div>
</div>

</body>
</html>
