<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Quest - Système Complet</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #FFD700;
            --secondary: #FFA500;
            --accent: #FFE566;
            --dark: #0A0A14;
            --dark-card: #1A1508;
            --text: #E0E0E0;
            --create: #4CAF50;
            --read: #2196F3;
            --update: #FF9800;
            --delete: #F44336;
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
            max-width: 1400px;
            margin: 0 auto;
        }

        .step-badge {
            display: inline-block;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--dark);
            padding: 0.5rem 1rem;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
            margin-bottom: 2rem;
            animation: pulse 2s infinite;
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); box-shadow: 0 0 40px rgba(255, 215, 0, 0.8); }
        }

        .title {
            font-family: 'Press Start 2P', cursive;
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            color: var(--primary);
            margin-bottom: 1rem;
            line-height: 1.5;
            text-shadow: 0 0 30px var(--primary);
        }

        .subtitle {
            font-size: 1.2rem;
            color: var(--accent);
            margin-bottom: 3rem;
        }

        .success-banner {
            background: var(--create);
            color: white;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
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

        .error-banner {
            background: var(--delete);
            color: white;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            font-family: 'Space Mono', monospace;
            font-size: 0.9rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            color: var(--primary);
            font-weight: bold;
            font-family: 'Press Start 2P', cursive;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .crud-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .tab-btn {
            flex: 1;
            min-width: 150px;
            padding: 1rem;
            background: rgba(255, 215, 0, 0.1);
            border: 2px solid var(--primary);
            border-radius: 4px;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text);
        }

        .tab-btn:hover {
            background: rgba(255, 215, 0, 0.2);
            transform: translateY(-2px);
        }

        .tab-btn.active {
            background: var(--primary);
            color: var(--dark);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.5);
        }

        .tab-btn.create { border-color: var(--create); }
        .tab-btn.create.active { background: var(--create); }

        .tab-btn.read { border-color: var(--read); }
        .tab-btn.read.active { background: var(--read); }

        .tab-btn.update { border-color: var(--update); }
        .tab-btn.update.active { background: var(--update); }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-card {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-card h3 {
            font-family: 'Press Start 2P', cursive;
            margin-bottom: 1.5rem;
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
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.5);
        }

        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--dark);
            border: none;
            border-radius: 4px;
            font-family: 'Press Start 2P', cursive;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 0 rgba(0, 0, 0, 0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0 rgba(0, 0, 0, 0.3), 0 0 20px var(--primary);
        }

        .submit-btn:active {
            transform: translateY(2px);
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.3);
        }

        .products-table {
            background: var(--dark-card);
            border: 2px solid var(--primary);
            border-radius: 8px;
            padding: 1.5rem;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
        }

        th {
            background: rgba(255, 215, 0, 0.1);
            color: var(--primary);
            font-family: 'Press Start 2P', cursive;
            font-size: 0.7rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            font-family: 'Space Mono', monospace;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
            text-decoration: none;
            display: inline-block;
        }

        .action-btn.edit {
            background: var(--update);
            color: white;
        }

        .action-btn.delete {
            background: var(--delete);
            color: white;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            opacity: 0.5;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            margin-top: 3rem;
            flex-wrap: wrap;
            justify-content: center;
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
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--dark);
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
    <div class="step-badge">🏆 ÉTAPE 6 - CRUD MASTER 🏆</div>

    <h1 class="title">Système CRUD Complet</h1>
    <p class="subtitle">Toutes les opérations en un seul endroit !</p>

    @if(session('success'))
        <div class="success-banner">✅ {{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="error-banner">
            <strong>Erreurs :</strong>
            <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-value">{{ $products->count() }}</div>
            <div class="stat-label">Total Produits</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">➕</div>
            <div class="stat-value">{{ $createdToday ?? 0 }}</div>
            <div class="stat-label">Créés (Aujourd'hui)</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✏️</div>
            <div class="stat-value">{{ $updatedToday ?? 0 }}</div>
            <div class="stat-label">Modifiés (Aujourd'hui)</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-value">{{ number_format($totalValue ?? 0, 2) }}€</div>
            <div class="stat-label">Valeur du Stock</div>
        </div>
    </div>

    <div class="crud-tabs">
        <button class="tab-btn create {{ !request('id') ? 'active' : '' }}" onclick="switchTab('create')">
            ➕ CREATE
        </button>
        <button class="tab-btn read" onclick="switchTab('read')">
            👁️ READ
        </button>
        <button class="tab-btn update {{ request('id') ? 'active' : '' }}" onclick="switchTab('update')">
            ✏️ UPDATE
        </button>
    </div>

    <!-- CREATE Tab -->
    <div class="tab-content {{ !request('id') ? 'active' : '' }}" id="createTab">
        <div class="form-card">
            <h3 style="color: var(--create);">➕ Ajouter un nouveau produit</h3>
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nom du produit *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <span style="color: var(--delete); font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <span style="color: var(--delete); font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Prix (€) *</label>
                    <input type="number" id="price" name="price" step="0.01" value="{{ old('price') }}" required>
                    @error('price')
                    <span style="color: var(--delete); font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                    @error('stock')
                    <span style="color: var(--delete); font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="submit-btn">➕ Créer le produit</button>
            </form>
        </div>
    </div>

    <!-- READ Tab -->
    <div class="tab-content" id="readTab">
        <div class="products-table">
            <h3 style="font-family: 'Press Start 2P', cursive; color: var(--read); margin-bottom: 1.5rem; text-align: center;">
                👁️ Liste des produits
            </h3>
            @if($products->count() > 0)
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $p)
                        <tr>
                            <td>#{{ $p->id }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ Str::limit($p->description ?? 'N/A', 30) }}</td>
                            <td>{{ number_format($p->price, 2) }}€</td>
                            <td>{{ $p->stock }}</td>
                            <td>
                                <a href="?id={{ $p->id }}" class="action-btn edit" onclick="switchTab('update')">✏️ Modifier</a>
                                <form action="{{ route('products.destroy', $p->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                    <p>Aucun produit dans la base</p>
                    <p style="font-size: 0.9rem; opacity: 0.7;">Ajoutez-en un dans l'onglet CREATE</p>
                </div>
            @endif
        </div>
    </div>

    <!-- UPDATE Tab -->
    <div class="tab-content {{ request('id') ? 'active' : '' }}" id="updateTab">
        <div class="form-card">
            @php
                $editProduct = request('id') ? $products->find(request('id')) : null;
            @endphp

            @if($editProduct)
                <h3 style="color: var(--update);">✏️ Modifier le produit #{{ $editProduct->id }}</h3>
                <form action="{{ route('products.update', $editProduct->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="edit_name">Nom du produit *</label>
                        <input type="text" id="edit_name" name="name" value="{{ old('name', $editProduct->name) }}" required>
                        @error('name')
                        <span style="color: var(--delete); font-size: 0.85rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea id="edit_description" name="description" rows="3">{{ old('description', $editProduct->description) }}</textarea>
                        @error('description')
                        <span style="color: var(--delete); font-size: 0.85rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_price">Prix (€) *</label>
                        <input type="number" id="edit_price" name="price" step="0.01" value="{{ old('price', $editProduct->price) }}" required>
                        @error('price')
                        <span style="color: var(--delete); font-size: 0.85rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_stock">Stock *</label>
                        <input type="number" id="edit_stock" name="stock" value="{{ old('stock', $editProduct->stock) }}" required>
                        @error('stock')
                        <span style="color: var(--delete); font-size: 0.85rem;">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="submit-btn" style="background: var(--update); color: white;">
                        ✏️ Mettre à jour le produit
                    </button>
                </form>
            @else
                <div class="empty-state">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">✏️</div>
                    <p>Aucun produit sélectionné</p>
                    <p style="font-size: 0.9rem; opacity: 0.7;">Cliquez sur "Modifier" dans l'onglet READ</p>
                </div>
            @endif
        </div>
    </div>

    <div class="button-group">
        <a href="/crud-quest" class="button primary">🏠 Retour au menu</a>
    </div>
</div>

<script>
    function switchTab(tabId) {
        // Remove active class from all tabs and content
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

        // Add active class to selected tab and content
        const tabContent = document.getElementById(tabId + 'Tab');
        const tabButton = document.querySelector('.tab-btn.' + tabId);

        if (tabContent) tabContent.classList.add('active');
        if (tabButton) tabButton.classList.add('active');
    }

    // Auto-hide success messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successBanner = document.querySelector('.success-banner');
        if (successBanner) {
            setTimeout(() => {
                successBanner.style.animation = 'slideOut 0.5s ease-out forwards';
                setTimeout(() => successBanner.remove(), 500);
            }, 5000);
        }
    });

    // Add slideOut animation
    const style = document.createElement('style');
    style.textContent = `
            @keyframes slideOut {
                from {
                    opacity: 1;
                    transform: translateY(0);
                }
                to {
                    opacity: 0;
                    transform: translateY(-20px);
                }
            }
        `;
    document.head.appendChild(style);
</script>
</body>
</html>
