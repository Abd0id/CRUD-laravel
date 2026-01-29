<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Quest - Étape 5: Delete</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #F44336;
            --secondary: #D32F2F;
            --accent: #EF5350;
            --dark: #0A0A14;
            --dark-card: #1F0808;
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
            50% { transform: scale(1.05); box-shadow: 0 0 20px rgba(244, 67, 54, 0.5); }
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
            box-shadow: 0 0 20px rgba(244, 67, 54, 0.3);
        }

        .code-block pre {
            color: var(--primary);
            line-height: 1.8;
        }

        .comment { color: #888; }
        .keyword { color: #EF5350; }
        .string { color: #81C784; }

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
        }

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
            position: relative;
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
            box-shadow: 0 0 20px rgba(244, 67, 54, 0.3);
        }

        .product-card.deleting {
            animation: cardDelete 0.5s ease-out forwards;
        }

        @keyframes cardDelete {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                transform: scale(0.95) rotate(-2deg);
                background: rgba(244, 67, 54, 0.3);
            }
            100% {
                opacity: 0;
                transform: scale(0.5) rotate(-5deg);
            }
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
            margin-bottom: 1rem;
        }

        .delete-btn {
            width: 100%;
            padding: 0.75rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 4px;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 0 var(--secondary);
        }

        .delete-btn:hover {
            background: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 6px 0 var(--secondary);
        }

        .delete-btn:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 var(--secondary);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            opacity: 0.5;
            grid-column: 1 / -1;
        }

        /* Confirmation Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modal-overlay.show {
            display: flex;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal {
            background: var(--dark-card);
            border: 3px solid var(--primary);
            border-radius: 8px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal h3 {
            font-family: 'Press Start 2P', cursive;
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .modal p {
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .modal-product-info {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid var(--primary);
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .modal-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .modal-btn {
            padding: 1rem;
            border: none;
            border-radius: 4px;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-btn.confirm {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 0 var(--secondary);
        }

        .modal-btn.confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 var(--secondary);
        }

        .modal-btn.cancel {
            background: transparent;
            border: 2px solid var(--text);
            color: var(--text);
        }

        .modal-btn.cancel:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: rgba(244, 67, 54, 0.1);
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
        <div class="step-badge">ÉTAPE 5 - DELETE 🗑️</div>

        <h1 class="title">Supprimer des Données</h1>
        <p class="subtitle">Effacer des produits de la base</p>

        <div class="info-card">
            <h2>🎯 L'opération DELETE</h2>
            <p>Le <strong>D</strong> de CRUD signifie <strong>Delete</strong> (Supprimer). Cette opération permet de supprimer définitivement des données de votre base.</p>
            <p><strong>⚠️ Attention :</strong> La suppression est une opération <strong>irréversible</strong> ! Toujours demander confirmation avant de supprimer.</p>
        </div>

        <div class="code-block">
            <pre>    public function step5()
    {
        // We get all products to show in the grid
        $products = Product::all();

        // We can calculate stats directly from the database
        $totalCount = $products->count();

        return view('crud-step-5-delete', compact('products', 'totalCount'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // Redirect back with a success message
        return redirect()->route('products.delete_page')
            ->with('success', '💥 Produit supprimé avec succès !');
    }</pre>
        </div>

        <div class="warning-box">
            <h3>⚠️ Bonnes Pratiques</h3>
            <ul style="margin-left: 2rem; line-height: 1.8;">
                <li>Toujours demander une <strong>confirmation</strong> avant suppression</li>
                <li>Privilégier le <strong>Soft Delete</strong> en production</li>
                <li>Vérifier les <strong>relations</strong> (foreign keys)</li>
                <li>Logger les suppressions pour l'audit</li>
                <li>Implémenter des <strong>politiques d'autorisation</strong></li>
            </ul>
        </div>

        <div class="stats-bar">
            <div class="stat-box">
                <div class="stat-value">{{ $totalCount }}</div>
                <div class="stat-label">Produits restants</div>
            </div>
        </div>

        <div class="products-grid" id="productsGrid">
            @forelse($products as $product)
                <div class="product-card">
                    <div class="product-header">
                        <span class="product-id">#{{ $product->id }}</span>
                    </div>
                    <h3>{{ $product->name }}</h3>
                    <p class="product-description">{{ $product->description }}</p>

                    <div class="product-footer">
                        <div>
                            <div style="font-size: 1.2rem; color: var(--accent); font-weight: bold;">
                                {{ number_format($product->price, 2) }}€
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer ce produit ? Cette action est irréversible !');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">
                            🗑️ Supprimer
                        </button>
                    </form>
                </div>
            @empty
                <div class="empty-state">
                    <p>Aucun produit à supprimer.</p>
                </div>
            @endforelse
        </div>

        <div class="button-group">
            <a href="/crud-quest/step-4-update" class="button secondary">← Étape 4: Update</a>
            <a href="/crud-quest/step-6-complete" class="button primary">→ Étape 6: Système Complet</a>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <h3>⚠️ Confirmer la suppression</h3>
            <p>Êtes-vous sûr de vouloir supprimer ce produit ?</p>
            <div class="modal-product-info" id="modalProductInfo"></div>
            <p style="color: var(--accent); font-weight: bold;">Cette action est irréversible !</p>
            <div class="modal-buttons">
                <button class="modal-btn cancel" onclick="closeModal()">Annuler</button>
                <button class="modal-btn confirm" onclick="confirmDelete()">🗑️ Supprimer</button>
            </div>
        </div>
    </div>

    <script>
        let products = JSON.parse(localStorage.getItem('crudProducts') || '[]');
        let deletedCount = parseInt(localStorage.getItem('deletedCount') || '0');
        let productToDelete = null;

        function updateStats() {
            document.getElementById('totalProducts').textContent = products.length;
            document.getElementById('deletedCount').textContent = deletedCount;
        }

        function renderProducts() {
            const grid = document.getElementById('productsGrid');

            if (products.length === 0) {
                grid.innerHTML = `
                    <div class="empty-state">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">🗑️</div>
                        <p>Aucun produit à supprimer</p>
                        <p style="font-size: 0.9rem; opacity: 0.7;">Ajoutez des produits aux étapes précédentes</p>
                    </div>
                `;
                return;
            }

            grid.innerHTML = products.map(product => `
                <div class="product-card" id="card-${product.id}">
                    <div class="product-header">
                        <span class="product-id">#${product.id}</span>
                    </div>
                    <h3>${product.name}</h3>
                    <p class="product-description">
                        ${product.description || 'Pas de description'}
                    </p>
                    <div class="product-footer">
                        <div>
                            <div style="font-size: 1.2rem; color: var(--accent); font-weight: bold;">
                                ${product.price.toFixed(2)}€
                            </div>
                            <div style="font-size: 0.85rem; opacity: 0.8; margin-top: 0.25rem;">
                                📦 Stock: ${product.stock}
                            </div>
                        </div>
                    </div>
                    <button class="delete-btn" onclick="showDeleteConfirmation(${product.id})">
                        🗑️ Supprimer
                    </button>
                </div>
            `).join('');
        }

        window.showDeleteConfirmation = function(id) {
            productToDelete = products.find(p => p.id === id);
            if (productToDelete) {
                document.getElementById('modalProductInfo').innerHTML = `
                    <strong>${productToDelete.name}</strong><br>
                    Prix: ${productToDelete.price.toFixed(2)}€<br>
                    Stock: ${productToDelete.stock}<br>
                    ID: #${productToDelete.id}
                `;
                document.getElementById('modalOverlay').classList.add('show');
            }
        };

        window.closeModal = function() {
            document.getElementById('modalOverlay').classList.remove('show');
            productToDelete = null;
        };

        window.confirmDelete = function() {
            if (productToDelete) {
                const card = document.getElementById(`card-${productToDelete.id}`);
                card.classList.add('deleting');

                setTimeout(() => {
                    products = products.filter(p => p.id !== productToDelete.id);
                    localStorage.setItem('crudProducts', JSON.stringify(products));

                    deletedCount++;
                    localStorage.setItem('deletedCount', deletedCount.toString());

                    closeModal();
                    updateStats();
                    renderProducts();
                }, 500);
            }
        };

        // Close modal on overlay click
        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        updateStats();
        renderProducts();
    </script>
</body>
</html>
