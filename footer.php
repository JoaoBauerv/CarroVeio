<!-- Footer CarroVeio -->
<footer class="footer-carrovelho mt-auto pt-5">

  <!-- Corpo do footer -->
  <div class="footer-body py-4">
    <div class="container">
      <div class="row g-4">

        <!-- Coluna 1 – Marca -->
        <div class="col-12 col-md-4">
          <div class="d-flex align-items-center gap-2 mb-2">
            <div class="footer-icon">
              <i class="bi bi-wrench-adjustable"></i>
            </div>
            <div>
              <div class="footer-brand-name">CarroVeio</div>
              <div class="footer-brand-sub">diário de manutenções</div>
            </div>
          </div>
          <p class="footer-desc">
            Anote tudo que acontece com o seu carro — troca de óleo, revisões,
            peças trocadas e muito mais. Simples e sem frescura.
          </p>
        </div>

        <?php if(!empty($_SESSION['usuario'])){ ?>

        <!-- Coluna 2 – Navegação -->
        <div class="col-6 col-md-2 offset-md-1">
          <h6 class="footer-heading">Navegação</h6>
          <ul class="footer-links">
            <li><a href="/index.php"><i class="bi bi-house"></i> Início</a></li>
            <li><a href="/manutencoes.php"><i class="bi bi-clipboard2-check"></i> Manutenções</a></li>
            <li><a href="/despesas.php"><i class="bi bi-cash-stack"></i> Despesas</a></li>
            <li><a href="/carro.php"><i class="bi bi-car-front"></i> Meu Carro</a></li>
          </ul>
        </div>

        <!-- Coluna 3 – Atalhos -->
        <div class="col-6 col-md-2">
          <h6 class="footer-heading">Atalhos</h6>
          <ul class="footer-links">
            <li><a href="/nova-manutencao.php"><i class="bi bi-plus-circle"></i> Nova manutenção</a></li>
            <li><a href="/historico.php"><i class="bi bi-clock-history"></i> Histórico</a></li>
            <li><a href="/relatorio.php"><i class="bi bi-bar-chart-line"></i> Relatório</a></li>
            <li><a href="/configuracoes.php"><i class="bi bi-gear"></i> Configurações</a></li>
          </ul>
        </div>
        

        <!-- Coluna 4 – Próxima revisão -->
        <div class="col-12 col-md-3">
          <h6 class="footer-heading">Próxima revisão</h6>
          <div class="revisao-card">
            <div class="revisao-item">
              <i class="bi bi-droplet-half text-warning"></i>
              <span>Troca de óleo</span>
              <span class="badge-revisao badge-ok">OK</span>
            </div>
            <div class="revisao-item">
              <i class="bi bi-fan text-info"></i>
              <span>Filtro de ar</span>
              <span class="badge-revisao badge-warn">Em breve</span>
            </div>
            <div class="revisao-item">
              <i class="bi bi-circle-half text-danger"></i>
              <span>Pastilha de freio</span>
              <span class="badge-revisao badge-danger">Urgente</span>
            </div>
            <a href="/manutencoes.php" class="btn-ver-tudo">
              Ver tudo <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>

        <?php } ?>

      </div>
    </div>
  </div>

</footer>

<style>
  :root {
    --cv-laranja: #d85a30;
    --cv-laranja-escuro: #993c1d;
    --cv-cinza: #2c2c2a;
  }

  .footer-carrovelho {
    font-family: 'Segoe UI', sans-serif;
  }

  /* Corpo */
  .footer-body {
    background-color: #1e1e1c;
    color: #ccc;
  }

  /* Marca */
  .footer-icon {
    width: 40px;
    height: 40px;
    background-color: var(--cv-laranja);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.2rem;
    flex-shrink: 0;
  }

  .footer-brand-name {
    font-size: 1.15rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.1;
  }

  .footer-brand-sub {
    font-size: 0.68rem;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .footer-desc {
    font-size: 0.82rem;
    color: #888;
    line-height: 1.6;
    margin-top: 0.5rem;
    margin-bottom: 0;
  }

  /* Headings das colunas */
  .footer-heading {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--cv-laranja);
    margin-bottom: 0.75rem;
  }

  /* Links */
  .footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .footer-links li {
    margin-bottom: 0.45rem;
  }

  .footer-links a {
    color: #aaa;
    text-decoration: none;
    font-size: 0.85rem;
    transition: color 0.15s;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .footer-links a i {
    font-size: 0.9rem;
    color: #666;
  }

  .footer-links a:hover {
    color: #fff;
  }

  .footer-links a:hover i {
    color: var(--cv-laranja);
  }

  /* Card de revisão */
  .revisao-card {
    background-color: #2a2a28;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    border: 0.5px solid #3a3a38;
  }

  .revisao-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.82rem;
    color: #bbb;
    padding: 5px 0;
    border-bottom: 0.5px solid #333;
  }

  .revisao-item:last-of-type {
    border-bottom: none;
  }

  .revisao-item span:nth-child(2) {
    flex: 1;
  }

  .badge-revisao {
    font-size: 0.68rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
  }

  .badge-ok      { background-color: #1a3d2b; color: #4ade80; }
  .badge-warn    { background-color: #3d2e0a; color: #fbbf24; }
  .badge-danger  { background-color: #3d1010; color: #f87171; }

  .btn-ver-tudo {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    margin-top: 0.6rem;
    font-size: 0.78rem;
    color: var(--cv-laranja);
    text-decoration: none;
    font-weight: 600;
    transition: gap 0.15s;
  }

  .btn-ver-tudo:hover {
    color: #f0845a;
    gap: 8px;
  }

  
</style>