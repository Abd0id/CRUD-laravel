<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Quest - Étape 4: Update</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Space+Mono:wght@400;700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --primary: #FF9800;
            --secondary: #F57C00;
            --accent: #FFB74D;
            --dark: #0A0A14;
            --dark-card: #1F1408;
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
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 0 20px rgba(255, 152, 0, 0.5);
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
            box-shadow: 0 0 20px rgba(255, 152, 0, 0.3);
        }

        .code-block pre {
            color: var(--primary);
            line-height: 1.8;
        }

        .comment {
            color: #888;
        }

        .keyword {
            color: #FFB74D;
        }

        .string {
            color: #81C784;
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

        .products-list {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 1.5rem;
            max-height: 600px;
            overflow-y: auto;
        }

        .products-list h3 {
            font-family: 'Press Start 2P', cursive;
            font-size: 0.9rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .product-item {
            background: rgba(255, 152, 0, 0.1);
            border: 1px solid var(--primary);
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-item:hover {
            background: rgba(255, 152, 0, 0.2);
            transform: translateX(5px);
        }

        .product-item.selected {
            border-color: var(--accent);
            background: rgba(255, 152, 0, 0.3);
        }

        .product-item h4 {
            color: var(--accent);
            margin-bottom: 0.5rem;
        }

        .edit-form {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 2rem;
        }

        .edit-form h3 {
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
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 15px rgba(255, 152, 0, 0.5);
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
            box-shadow: 0 6px 0 var(--secondary);
        }

        .submit-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            opacity: 0.5;
        }

        .success-message {
            background: rgba(76, 175, 80, 0.2);
            border: 2px solid #4CAF50;
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1rem;
            display: none;
        }

        .success-message.show {
            display: block;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
    <div class="step-badge">ÉTAPE 4 - UPDATE ✏️</div>

    <h1 class="title">Modifier les Données</h1>
    <p class="subtitle">Mettre à jour les produits existants</p>

    <div class="info-card">
        <h2>🎯 L'opération UPDATE</h2>
        <p>Le <strong>U</strong> de CRUD signifie <strong>Update</strong> (Mettre à jour). Cette opération permet de
            modifier des données existantes dans votre base.</p>
        <p>Avec Laravel Eloquent, vous pouvez mettre à jour des enregistrements de plusieurs façons.</p>
    </div>

    <div class="code-block">
            <pre>public function step4(Request $request) {
    $products = Product::all();
    $selectedProduct = $request->has('id') ? Product::find($request->id) : null;
    return view('crud-step-4-update', compact('products', 'selectedProduct'));
}

public function update(Request $request, $id) {
    $product = Product::findOrFail($id);
    $product->update($request->all());
    return redirect()->route('products.edit')->with('success', 'Mis à jour !');
}</pre>
    </div>

    <div class="two-columns">
        <!-- Left: Products List -->
        <div>
            <div id="productsList">
                @forelse($products as $product)
                    {{-- This link reloads the page and sends the ?id=... to your step4 method --}}
                    <a href="{{ route('products.edit', ['id' => $product->id]) }}"
                       style="text-decoration: none; color: inherit;">
                        <div
                            class="product-item {{ (isset($selectedProduct) && $selectedProduct->id == $product->id) ? 'selected' : '' }}">
                            <h4>{{ $product->name }}</h4>
                            <div style="display: flex; gap: 1rem; font-size: 0.9rem; opacity: 0.9;">
                                <span>💰 {{ number_format($product->price, 2) }}€</span>
                                <span>📦 {{ $product->stock }}</span>
                                <span>🆔 #{{ $product->id }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <p>Aucun produit en base de données.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right: Edit Form -->
        <div>
            <div class="edit-form">
                <h3>✏️ Modifier le produit {{ $selectedProduct ? "#" . $selectedProduct->id : "" }}</h3>

                @if(session('success'))
                    <div class="success-message show">{{ session('success') }}</div>
                @endif

                @if($selectedProduct)
                    <form action="{{ route('products.update', $selectedProduct->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nom du produit</label>
                            <input type="text" name="name" value="{{ $selectedProduct->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description">{{ $selectedProduct->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Prix (€)</label>
                            <input type="number" name="price" step="0.01" value="{{ $selectedProduct->price }}"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" value="{{ $selectedProduct->stock }}" required>
                        </div>

                        <button type="submit" class="submit-btn">✏️ Sauvegarder les modifications</button>
                    </form>
                @else
                    <div class="empty-state">
                        <p>Sélectionnez un produit à gauche pour le modifier.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="button-group">
        <a href="/crud-quest/step-3-read" class="button secondary">← Étape 3: Read</a>
        <a href="/crud-quest/step-5-delete" class="button primary">→ Étape 5: Delete</a>
    </div>
</div>

</body>
</html>
