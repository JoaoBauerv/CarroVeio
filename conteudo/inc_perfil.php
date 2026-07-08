<?php

$stmt = $pdo->prepare("SELECT id, marca, modelo, ano, placa, cor, quilometragem, foto FROM cars WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute(['user_id' => $_SESSION['usuario']]);
$carros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Olá, <?php echo htmlspecialchars($_SESSION['user_nome']); ?></h2>
            <p class="text-muted mb-0"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
        </div>

        <a href="<?php echo $url_base; ?>/index.php?secao=cadastro_carro" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Adicionar Carro
        </a>
    </div>

    <h4 class="mb-3">Meus Carros</h4>

    <?php if (empty($carros)): ?>

        <div class="alert alert-light border text-center py-5">
            <i class="bi bi-car-front display-4 d-block mb-3 text-muted"></i>
            Você ainda não cadastrou nenhum carro.
        </div>

    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($carros as $carro): ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">

                        <?php if (!empty($carro['foto'])): ?>
                            <img src="<?php echo $url_base . '/' . htmlspecialchars($carro['foto']); ?>"
                                 class="card-img-top"
                                 style="height: 180px; object-fit: cover;"
                                 alt="<?php echo htmlspecialchars($carro['marca'] . ' ' . $carro['modelo']); ?>">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light"
                                 style="height: 180px;">
                                <i class="bi bi-car-front-fill display-4 text-muted"></i>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title mb-1">
                                <?php echo htmlspecialchars($carro['marca'] . ' ' . $carro['modelo']); ?>
                            </h5>
                            <p class="text-muted mb-2"><?php echo htmlspecialchars($carro['ano']); ?></p>

                            <ul class="list-unstyled small mb-0">
                                <?php if (!empty($carro['placa'])): ?>
                                    <li><strong>Placa:</strong> <?php echo htmlspecialchars($carro['placa']); ?></li>
                                <?php endif; ?>

                                <?php if (!empty($carro['cor'])): ?>
                                    <li><strong>Cor:</strong> <?php echo htmlspecialchars($carro['cor']); ?></li>
                                <?php endif; ?>

                                <?php if (!empty($carro['quilometragem'])): ?>
                                    <li><strong>KM:</strong> <?php echo number_format($carro['quilometragem'], 0, ',', '.'); ?> km</li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="card-footer bg-white border-0 pb-3">
                            <a href="<?php echo $url_base; ?>/index.php?secao=carro&id=<?php echo (int) $carro['id']; ?>"
                               class="btn btn-sm btn-outline-primary">
                                Ver detalhes
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>