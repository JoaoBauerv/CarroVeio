<style>
    :root {
      --cv-laranja: #d85a30;
      --cv-laranja-escuro: #993c1d;
      --cv-cinza: #2c2c2a;
    }

    body {
      background-color: #f5f4f0;
      font-family: 'Segoe UI', sans-serif;
          display: flex;
    flex-direction: column;
    min-height: 100vh;
    }

    /* ── Barra de topo ────────────────────────────── */
    .topbar {
      background-color: var(--cv-cinza);
      font-size: 0.8rem;
      color: #aaa;
      padding: 4px 0;
    }

    .topbar a {
      color: #aaa;
      text-decoration: none;
    }

    .topbar a:hover {
      color: #fff;
    }

    /* ── Navbar principal ─────────────────────────── */
    .navbar-carrovelho {
      background-color: #fff;
      border-bottom: 3px solid var(--cv-laranja);
      padding: 0.75rem 0;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
    }

    .brand-icon {
      width: 44px;
      height: 44px;
      background-color: var(--cv-laranja);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 1.4rem;
    }

    .brand-text-main {
      font-size: 1.35rem;
      font-weight: 700;
      color: var(--cv-cinza);
      line-height: 1;
    }

    .brand-text-sub {
      font-size: 0.7rem;
      color: #888;
      letter-spacing: 0.04em;
      text-transform: uppercase;
    }

    /* ── Links de navegação ───────────────────────── */
    .nav-link-cv {
      color: var(--cv-cinza) !important;
      font-weight: 500;
      font-size: 0.9rem;
      padding: 0.5rem 0.9rem !important;
      border-radius: 6px;
      transition: background 0.15s, color 0.15s;
    }

    .nav-link-cv:hover,
    .nav-link-cv.active {
      background-color: #faecea;
      color: var(--cv-laranja) !important;
    }

    .nav-link-cv i {
      font-size: 1rem;
      margin-right: 5px;
      vertical-align: -1px;
    }

    /* ── Botão nova manutenção ────────────────────── */
    .btn-nova-manut {
      background-color: var(--cv-laranja);
      color: #fff;
      border: none;
      border-radius: 7px;
      font-size: 0.875rem;
      font-weight: 600;
      padding: 0.45rem 1.1rem;
      display: flex;
      align-items: center;
      gap: 6px;
      transition: background 0.15s, transform 0.1s;
    }

    .btn-nova-manut:hover {
      background-color: var(--cv-laranja-escuro);
      color: #fff;
      transform: scale(0.98);
    }

    /* ── Hamburger ────────────────────────────────── */
    .navbar-toggler {
      border-color: #ddd;
    }

    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23444' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
  </style>
</head>
<body>

<!-- Barra de topo -->
<div class="topbar">
  <div class="container d-flex justify-content-between">
    <span><i class="bi bi-calendar3"></i> <?php echo date('d/m/Y'); ?></span>
    <span>
      <a href="#"><i class="bi bi-github"></i> GitHub</a>
      &nbsp;|&nbsp;
      <a href="#"><i class="bi bi-question-circle"></i> Ajuda</a>
    </span>
  </div>
</div>

<!-- Navbar principal -->
<nav class="navbar navbar-carrovelho navbar-expand-lg">
  <div class="container">

    <!-- Marca -->
    <a class="navbar-brand" href="/index.php">
      <div class="brand-icon">
        <i class="bi bi-wrench-adjustable"></i>
      </div>
      <div>
        <div class="brand-text-main">CarroVeio</div>
        <div class="brand-text-sub">diário de manutenções</div>
      </div>
    </a>

    <!-- Botão mobile -->
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navMenu"
      aria-controls="navMenu"
      aria-expanded="false"
      aria-label="Abrir menu"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Links -->
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="nav-link nav-link-cv active" href="index.php">
            <i class="bi bi-house"></i> Início
          </a>
        </li>
        <?php if(!empty($_SESSION['usuario'])){?>
        <li class="nav-item">
          <a class="nav-link nav-link-cv" href="/manutencoes.php">
            <i class="bi bi-clipboard2-check"></i> Manutenções
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-cv" href="/despesas.php">
            <i class="bi bi-cash-stack"></i> Despesas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-link-cv" href="/carro.php">
            <i class="bi bi-car-front"></i> Meu Carro
          </a>
        </li>
      </ul>

      <!-- Botão de ação -->
      <a href="/nova-manutencao.php" class="btn btn-nova-manut ms-lg-2 mt-2 mt-lg-0">
        <i class="bi bi-plus-circle"></i> Nova manutenção
      </a>
    </div>
    <?php } ?>

  </div>
</nav>