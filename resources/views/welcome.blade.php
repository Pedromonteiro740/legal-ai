<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Legal.AI - Match Inteligente</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Estilos e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #2563eb;
            --secondary: #7c3aed;
            --accent: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
        }

        body {
            margin-top: 100px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        header {
            background: white;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        header .navbar-brand {
            font-weight: bold;
            color: var(--primary);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .match-card {
            position: relative;
            border: none;
            transition: all 0.3s ease;
        }

        .match-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .affinity-badge {
            position: absolute;
            right: 20px;
            top: -20px; /* Ajustado para não sobrepor o título */
            width: 60px;
            height: 60px;
            background: var(--accent);
            color: white;
            font-weight: bold;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem; /* Tamanho do texto */
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.98);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .loader {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: conic-gradient(var(--primary) 0%, transparent 80%);
            mask: radial-gradient(farthest-side, transparent calc(100% - 8px), #000 0);
            animation: spin 1.5s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            margin: 0 auto;
        }

        /* Ajustando o alinhamento e tamanho do loader */
        .loading-overlay .loader {
            position: relative; /* Alterado para relative */
            margin: 0 auto; /* Centraliza o loader */
        }

        .match-card .match-info {
            margin-top: 20px;
        }

        .tags {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Header com logo e nome -->
<header class="py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="#">
            <i class="fa-solid fa-scale-balanced me-2"></i>Legal.AI
        </a>
    </div>
</header>

<!-- Conteúdo Principal -->
<div class="container py-5">
    <!-- CEO Section -->
    <div class="ceo-section text-white mb-5 p-4 bg-dark rounded-4">
        <div class="d-flex flex-column flex-md-row align-items-center gap-4">
            <div class="text-center">
                <i class="fa-solid fa-user-tie fa-3x mb-2"></i>
                <h5 class="mb-0">Wagner Sansevero</h5>
                <small>CEO & Fundador</small>
            </div>
            <blockquote class="mb-0">
                <p class="lead">"Na Legal.AI, combinamos tecnologia avançada com expertise jurídica para criar conexões que transformam carreiras."</p>
                <footer class="blockquote-footer text-white-50">Reconhecido pelo Prêmio Inovação Jurídica 2023</footer>
            </blockquote>
        </div>
    </div>

    <!-- Formulário -->
    <div class="glass-card">
        <h2 class="text-center mb-5 fw-bold">Encontre Sua Conexão Ideal</h2>
        <form method="POST" action="{{ route('buscar') }}">
            @csrf
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>
                        <label for="nome">Seu Nome</label>
                    </div>
                </div>

                <div class="col-md-4">
    <div class="form-floating">
        <select class="form-select" id="area" name="area" required>
            <option value="">Selecione...</option>
            <option>Direito Digital</option>
            <option>Propriedade Intelectual</option>
            <option>Regulatório</option>
            <option>Direito do Trabalho</option>
            <option>Contratos</option>
            <option>Tributário</option>
            <option>Societário</option>
            <option>Direito Penal</option>
        </select>
        <label for="area">Área de Interesse</label>
    </div>
</div>

                <div class="col-md-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="localizacao" name="localizacao" placeholder="Localização" required>
                        <label for="localizacao">Localização</label>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-dark px-5 py-3 rounded-pill">
                    <i class="fas fa-magic me-2"></i>Gerar Conexões
                </button>
            </div>
        </form>

        
        @if(session('matches'))
        <div class="mt-5 animate__animated animate__fadeInUp" id="match-section">
            <h4 class="text-center mb-4 fw-bold">Conexões Selecionadas para Você</h4>
            <div class="row g-4">
                @foreach(session('matches') as $match)
                <div class="col-md-4">
                    <div class="match-card bg-white p-4 rounded-4">
                        <div class="affinity-badge">
                            {{ round($match['peso'][$match['area']] * 100) }}%
                        </div>
                        <div class="text-center">
                            <div class="avatar">{{ initials($match['nome']) }}</div>
                            <h5 class="mt-3 mb-1">{{ $match['nome'] }}</h5>
                            <small class="text-muted d-block mb-2">{{ $match['cargo'] }}</small>
                            <p class="text-secondary">{{ $match['descricao'] }}</p>
                            <div class="match-info">
                                <small class="d-block">Área: {{ $match['area'] }}</small>
                                <small class="d-block">Localização: {{ $match['localizacao'] }}</small>
                            </div>
                            @if(!empty($match['tags']))
                            <div class="tags d-flex flex-wrap gap-2 justify-content-center">
                                @foreach($match['tags'] as $tag)
                                <span class="badge bg-light text-dark border">{{ $tag }}</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

           
            <div class="text-center mt-5 pt-4">
                <div class="btn-group" role="group">
                <button class="btn btn-success px-4 rounded-start-pill">
                        <i class="fas fa-thumbs-up me-2"></i>Ótimos Matches
                    </button>
                    <button id="refazerBuscaBtn" class="btn btn-outline-secondary px-4 rounded-end-pill">
                        <i class="fas fa-sync me-2"></i>Refazer Busca
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>


<div class="loading-overlay">
    <div class="text-center">
        <div class="loader"></div>
        <h3 class="mt-4 text-dark fw-bold">Analisando seu perfil...</h3>
        <p class="text-muted">Varrendo nossa rede de +2.000 profissionais qualificados</p>
    </div>
</div>


<script>
    document.querySelector('form').addEventListener('submit', () => {
        document.querySelector('.loading-overlay').style.display = 'flex';
    });

    document.getElementById('refazerBuscaBtn')?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Inicializa cores dos avatares
    const colors = ['#2563eb', '#7c3aed', '#f59e0b', '#10b981'];
    document.querySelectorAll('.avatar').forEach(avatar => {
        const randomColor = colors[Math.floor(Math.random() * colors.length)];
        avatar.style.backgroundColor = randomColor;
    });
</script>

</body>
</html>