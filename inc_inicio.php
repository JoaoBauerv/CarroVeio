<?php
// Dados de exemplo – substituir por consultas reais ao banco
$carro = [
  'nome'     => 'Fiat Uno Mille 2003',
  'placa'    => 'ABC-1234',
  'km'       => 142350,
  'cor'      => 'Branco',
  'combustivel' => 'Gasolina',
];

$proximas = [
  ['item' => 'Pastilha de freio',  'km_prev' => 143000, 'status' => 'danger', 'icon' => 'bi-circle-half'],
  ['item' => 'Filtro de ar',       'km_prev' => 145000, 'status' => 'warning','icon' => 'bi-fan'],
  ['item' => 'Troca de óleo',      'km_prev' => 148000, 'status' => 'success','icon' => 'bi-droplet-half'],
];

$historico = [
  ['data' => '10/06/2025', 'item' => 'Troca de óleo',         'km' => 140000, 'valor' => 120.00],
  ['data' => '02/04/2025', 'item' => 'Alinhamento e balanceamento', 'km' => 138500, 'valor' => 80.00],
  ['data' => '15/01/2025', 'item' => 'Vela de ignição',       'km' => 135000, 'valor' => 55.00],
  ['data' => '30/10/2024', 'item' => 'Correia dentada',       'km' => 130000, 'valor' => 350.00],
];

$total_gasto = array_sum(array_column($historico, 'valor'));
?>

  <style>
    :root {
      --cv-laranja:       #d85a30;
      --cv-laranja-esc:   #993c1d;
      --cv-cinza:         #2c2c2a;
      --cv-fundo:         #f5f4f0;
      --cv-card:          #ffffff;
    }

    * { box-sizing: border-box; }

    body {
      background: var(--cv-fundo);
      font-family: 'Segoe UI', sans-serif;
      color: var(--cv-cinza);
    }

    /* ── Hero ─────────────────────────────────── */
    .hero {
      background: linear-gradient(135deg, #1e1e1c 60%, #3a1e0f);
      color: #fff;
      padding: 3.5rem 0 2.5rem;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Ccircle cx='30' cy='30' r='1.2' fill='%23ffffff08'/%3E%3C/svg%3E");
    }

    .hero-label {
      font-size: 0.72rem;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--cv-laranja);
      font-weight: 600;
      margin-bottom: 0.4rem;
    }

    .hero h1 {
      font-size: clamp(1.6rem, 4vw, 2.6rem);
      font-weight: 800;
      line-height: 1.15;
      margin-bottom: 0.3rem;
    }

    .hero h1 span { color: var(--cv-laranja); }

    .hero-sub {
      color: #aaa;
      font-size: 0.9rem;
      margin-bottom: 1.5rem;
    }

    .hero-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 1.2rem;
    }

    .hero-meta-item {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.82rem;
      color: #ccc;
    }

    .hero-meta-item i { color: var(--cv-laranja); font-size: 1rem; }

    .hero-km {
      background: rgba(216,90,48,.15);
      border: 1px solid rgba(216,90,48,.3);
      border-radius: 10px;
      padding: 1rem 1.4rem;
      text-align: center;
    }

    .hero-km-num {
      font-size: 2rem;
      font-weight: 800;
      color: var(--cv-laranja);
      line-height: 1;
    }

    .hero-km-label {
      font-size: 0.72rem;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      margin-top: 2px;
    }

    /* ── Botão principal ──────────────────────── */
    .btn-cv {
      background: var(--cv-laranja);
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 0.55rem 1.3rem;
      font-weight: 600;
      font-size: 0.88rem;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      text-decoration: none;
      transition: background .15s, transform .1s;
    }

    .btn-cv:hover { background: var(--cv-laranja-esc); color: #fff; transform: scale(.98); }

    .btn-cv-outline {
      background: transparent;
      color: #ccc;
      border: 1px solid #444;
      border-radius: 8px;
      padding: 0.55rem 1.3rem;
      font-size: 0.88rem;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      text-decoration: none;
      transition: border-color .15s, color .15s;
    }

    .btn-cv-outline:hover { border-color: var(--cv-laranja); color: var(--cv-laranja); }

    /* ── Cards de stat ────────────────────────── */
    .stat-card {
      background: var(--cv-card);
      border-radius: 12px;
      padding: 1.25rem 1.4rem;
      box-shadow: 0 1px 4px rgba(0,0,0,.07);
      display: flex;
      align-items: center;
      gap: 1rem;
      border-left: 4px solid transparent;
      transition: box-shadow .15s;
    }

    .stat-card:hover { box-shadow: 0 4px 14px rgba(0,0,0,.1); }

    .stat-card.laranja { border-color: var(--cv-laranja); }
    .stat-card.verde   { border-color: #22c55e; }
    .stat-card.azul    { border-color: #3b82f6; }
    .stat-card.roxo    { border-color: #a855f7; }

    .stat-icon {
      width: 46px; height: 46px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.3rem;
      flex-shrink: 0;
    }

    .stat-icon.laranja { background: #faecea; color: var(--cv-laranja); }
    .stat-icon.verde   { background: #dcfce7; color: #16a34a; }
    .stat-icon.azul    { background: #dbeafe; color: #2563eb; }
    .stat-icon.roxo    { background: #f3e8ff; color: #9333ea; }

    .stat-num { font-size: 1.45rem; font-weight: 800; line-height: 1; }
    .stat-lbl { font-size: 0.75rem; color: #888; margin-top: 2px; }

    /* ── Seção ────────────────────────────────── */
    .section { padding: 2.2rem 0; }

    .section-title {
      font-size: 1rem;
      font-weight: 700;
      color: var(--cv-cinza);
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .section-title i { color: var(--cv-laranja); }

    /* ── Card base ────────────────────────────── */
    .cv-card {
      background: var(--cv-card);
      border-radius: 12px;
      box-shadow: 0 1px 4px rgba(0,0,0,.07);
      overflow: hidden;
    }

    /* ── Próximas manutenções ─────────────────── */
    .manut-item {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.85rem 1.2rem;
      border-bottom: 1px solid #f0efed;
      transition: background .12s;
    }

    .manut-item:last-child { border-bottom: none; }
    .manut-item:hover { background: #fafaf8; }

    .manut-icon {
      width: 38px; height: 38px; border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.1rem; flex-shrink: 0;
    }

    .manut-icon.danger  { background: #fee2e2; color: #dc2626; }
    .manut-icon.warning { background: #fef3c7; color: #d97706; }
    .manut-icon.success { background: #dcfce7; color: #16a34a; }

    .manut-info { flex: 1; }
    .manut-name { font-size: 0.88rem; font-weight: 600; color: var(--cv-cinza); }
    .manut-km   { font-size: 0.75rem; color: #888; }

    .badge-status {
      font-size: 0.68rem; font-weight: 600;
      padding: 3px 9px; border-radius: 20px;
    }

    .badge-danger  { background: #fee2e2; color: #dc2626; }
    .badge-warning { background: #fef3c7; color: #d97706; }
    .badge-success { background: #dcfce7; color: #16a34a; }

    /* ── Tabela histórico ─────────────────────── */
    .hist-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
    .hist-table th {
      text-align: left; padding: 0.75rem 1rem;
      font-size: 0.7rem; font-weight: 600;
      text-transform: uppercase; letter-spacing: 0.06em;
      color: #888; border-bottom: 1px solid #eee;
      background: #fafaf8;
    }

    .hist-table td {
      padding: 0.75rem 1rem;
      border-bottom: 1px solid #f0efed;
      color: var(--cv-cinza);
      vertical-align: middle;
    }

    .hist-table tr:last-child td { border-bottom: none; }
    .hist-table tr:hover td { background: #fafaf8; }

    .hist-valor { font-weight: 700; color: var(--cv-laranja); }

    /* ── Card do carro ────────────────────────── */
    .carro-card {
      background: linear-gradient(135deg, #2c2c2a, #1a1a18);
      border-radius: 12px;
      color: #fff;
      padding: 1.4rem;
      position: relative;
      overflow: hidden;
    }

    .carro-card::after {
      content: '\F5DE';
      font-family: 'Bootstrap-Icons';
      position: absolute;
      right: -10px; bottom: -15px;
      font-size: 7rem;
      color: rgba(255,255,255,.04);
      pointer-events: none;
    }

    .carro-titulo { font-size: 1rem; font-weight: 700; margin-bottom: 0.1rem; }
    .carro-placa  {
      display: inline-block;
      background: var(--cv-laranja); color: #fff;
      font-size: 0.7rem; font-weight: 700;
      padding: 2px 8px; border-radius: 4px;
      letter-spacing: 0.08em; margin-bottom: 1rem;
    }

    .carro-dados { display: flex; flex-direction: column; gap: 0.45rem; }
    .carro-dado  { display: flex; justify-content: space-between; font-size: 0.82rem; }
    .carro-dado span:first-child { color: #888; }
    .carro-dado span:last-child  { color: #fff; font-weight: 600; }

    /* ── Ação rápida ──────────────────────────── */
    .acao-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.7rem; }

    .acao-btn {
      background: #fff;
      border: 1px solid #e8e7e4;
      border-radius: 10px;
      padding: 0.9rem;
      text-align: center;
      text-decoration: none;
      color: var(--cv-cinza);
      font-size: 0.8rem;
      font-weight: 600;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      transition: border-color .15s, box-shadow .15s;
    }

    .acao-btn i { font-size: 1.3rem; color: var(--cv-laranja); }
    .acao-btn:hover { border-color: var(--cv-laranja); box-shadow: 0 2px 8px rgba(216,90,48,.12); color: var(--cv-cinza); }

    /* ── Responsive tweaks ────────────────────── */
    @media (max-width: 576px) {
      .hero { padding: 2rem 0 1.5rem; }
      .acao-grid { grid-template-columns: repeat(2,1fr); }
    }
  </style>
</head>
<body>


<!-- ── Hero ──────────────────────────────────────── -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-8">
        <div class="hero-label">Painel do motorista</div>
        <h1>Olá, bem-vindo ao<br><span>CarroVeio</span></h1>
        <p class="hero-sub">Tudo sobre o seu carro em um lugar só — manutenções, gastos e lembretes.</p>
        <div class="hero-meta mb-3">
          <div class="hero-meta-item"><i class="bi bi-car-front"></i><?= $carro['nome'] ?></div>
          <div class="hero-meta-item"><i class="bi bi-geo-alt"></i>Placa <?= $carro['placa'] ?></div>
          <div class="hero-meta-item"><i class="bi bi-fuel-pump"></i><?= $carro['combustivel'] ?></div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
          <a href="/nova-manutencao.php" class="btn-cv"><i class="bi bi-plus-circle"></i> Nova manutenção</a>
          <a href="/manutencoes.php" class="btn-cv-outline"><i class="bi bi-list-check"></i> Ver histórico</a>
        </div>
      </div>
      <div class="col-lg-4 d-flex justify-content-lg-end justify-content-start">
        <div class="hero-km">
          <div class="hero-km-num"><?= number_format($carro['km'], 0, ',', '.') ?></div>
          <div class="hero-km-label">km rodados</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Stats ──────────────────────────────────────── -->
<section class="section pb-0">
  <div class="container">
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <div class="stat-card laranja">
          <div class="stat-icon laranja"><i class="bi bi-clipboard2-check"></i></div>
          <div>
            <div class="stat-num"><?= count($historico) ?></div>
            <div class="stat-lbl">Manutenções</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card verde">
          <div class="stat-icon verde"><i class="bi bi-cash-stack"></i></div>
          <div>
            <div class="stat-num">R$ <?= number_format($total_gasto, 0, ',', '.') ?></div>
            <div class="stat-lbl">Total gasto</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card azul">
          <div class="stat-icon azul"><i class="bi bi-exclamation-triangle"></i></div>
          <div>
            <div class="stat-num"><?= count(array_filter($proximas, fn($p) => $p['status'] === 'danger')) ?></div>
            <div class="stat-lbl">Urgentes</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="stat-card roxo">
          <div class="stat-icon roxo"><i class="bi bi-calendar-check"></i></div>
          <div>
            <div class="stat-num"><?= date('Y') - 2003 ?> anos</div>
            <div class="stat-lbl">Idade do carro</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Conteúdo principal ─────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="row g-4">

      <!-- Coluna esquerda -->
      <div class="col-lg-8">

        <!-- Próximas manutenções -->
        <div class="section-title"><i class="bi bi-bell"></i> Próximas manutenções</div>
        <div class="cv-card mb-4">
          <?php foreach ($proximas as $p): ?>
          <div class="manut-item">
            <div class="manut-icon <?= $p['status'] ?>">
              <i class="bi <?= $p['icon'] ?>"></i>
            </div>
            <div class="manut-info">
              <div class="manut-name"><?= $p['item'] ?></div>
              <div class="manut-km">Prev. em <?= number_format($p['km_prev'], 0, ',', '.') ?> km</div>
            </div>
            <?php
              $labels = ['danger'=>'Urgente','warning'=>'Em breve','success'=>'OK'];
            ?>
            <span class="badge-status badge-<?= $p['status'] ?>"><?= $labels[$p['status']] ?></span>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Histórico recente -->
        <div class="section-title"><i class="bi bi-clock-history"></i> Histórico recente</div>
        <div class="cv-card">
          <div class="table-responsive">
            <table class="hist-table">
              <thead>
                <tr>
                  <th>Data</th>
                  <th>Serviço</th>
                  <th>KM</th>
                  <th>Valor</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($historico as $h): ?>
                <tr>
                  <td><?= $h['data'] ?></td>
                  <td><?= $h['item'] ?></td>
                  <td><?= number_format($h['km'], 0, ',', '.') ?> km</td>
                  <td class="hist-valor">R$ <?= number_format($h['valor'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <div class="p-3 border-top d-flex justify-content-between align-items-center">
            <span style="font-size:.8rem;color:#888;">Mostrando <?= count($historico) ?> registros</span>
            <a href="/manutencoes.php" class="btn-cv" style="font-size:.8rem;padding:.4rem 1rem;">
              Ver todas <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>

      </div>

      <!-- Coluna direita -->
      <div class="col-lg-4">

        <!-- Card do carro -->
        <div class="section-title"><i class="bi bi-car-front"></i> Meu carro</div>
        <div class="carro-card mb-4">
          <div class="carro-titulo"><?= $carro['nome'] ?></div>
          <div class="carro-placa"><?= $carro['placa'] ?></div>
          <div class="carro-dados">
            <div class="carro-dado"><span>Cor</span><span><?= $carro['cor'] ?></span></div>
            <div class="carro-dado"><span>Combustível</span><span><?= $carro['combustivel'] ?></span></div>
            <div class="carro-dado"><span>KM atual</span><span><?= number_format($carro['km'], 0, ',', '.') ?></span></div>
            <div class="carro-dado"><span>Ano</span><span>2003</span></div>
          </div>
          <a href="/carro.php" class="btn-cv mt-3 w-100 justify-content-center">
            <i class="bi bi-pencil"></i> Editar dados
          </a>
        </div>

        <!-- Ações rápidas -->
        <div class="section-title"><i class="bi bi-lightning"></i> Ações rápidas</div>
        <div class="acao-grid">
          <a href="/nova-manutencao.php" class="acao-btn">
            <i class="bi bi-plus-circle"></i> Nova manutenção
          </a>
          <a href="/despesas.php" class="acao-btn">
            <i class="bi bi-cash-coin"></i> Registrar gasto
          </a>
          <a href="/relatorio.php" class="acao-btn">
            <i class="bi bi-bar-chart-line"></i> Relatório
          </a>
          <a href="/configuracoes.php" class="acao-btn">
            <i class="bi bi-gear"></i> Configurações
          </a>
        </div>

      </div>
    </div>
  </div>
</section>