<div class="container py-5">
    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow border-0">
                <div class="card-body p-5">

                    <h2 class="mb-4">Cadastrar Carro</h2>

                    <form id="formCadastroCarro" novalidate>

                        <div class="mb-3">
                            <label class="form-label">Marca</label>
                            <select class="form-control" name="marca" id="selectMarca">
                                <option value="">Carregando marcas...</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Modelo</label>
                            <select class="form-control" name="modelo" id="selectModelo" disabled>
                                <option value="">Selecione a marca primeiro</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Ano</label>
                                <input type="number" class="form-control" name="ano" placeholder="Ex: 2020" min="1900" max="2100">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Placa</label>
                                <input type="text" class="form-control" name="placa" placeholder="Ex: ABC1D23" maxlength="10">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Cor</label>
                                <input type="text" class="form-control" name="cor" placeholder="Ex: Prata">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quilometragem</label>
                            <input type="number" class="form-control" name="quilometragem" placeholder="Ex: 45000" min="0">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Foto do carro</label>
                            <input type="file" class="form-control" name="foto" accept="image/png, image/jpeg, image/webp">
                            <small class="text-muted">Opcional. JPG, PNG ou WEBP, até 5MB.</small>
                        </div>

                        <div class="invalid-feedback d-block error-msg-carro mb-3"></div>

                        <div class="d-flex gap-2">
                            <a href="<?php echo $url_base; ?>/index.php?secao=perfil" class="btn btn-light">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success" id="btnSalvarCarro">
                                Salvar Carro
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<script>
const formCarro = document.getElementById('formCadastroCarro');
const selectMarca = document.getElementById('selectMarca');
const selectModelo = document.getElementById('selectModelo');

// Caminhos absolutos a partir da raiz do site
const URL_CADASTRAR_CARRO = '<?php echo $url_base; ?>/includes/ajax/cadastrar_carro.php';
const URL_MARCAS = '<?php echo $url_base; ?>/includes/ajax/marcas.php';
const URL_MODELOS = '<?php echo $url_base; ?>/includes/ajax/modelos.php';

// Carrega as marcas ao abrir a página 
async function carregarMarcas() {
    try {
        const resp = await fetch(URL_MARCAS);
        const data = await resp.json();

        if (!data.success) {
            selectMarca.innerHTML = '<option value="">Erro ao carregar marcas</option>';
            return;
        }

        selectMarca.innerHTML = '<option value="">Selecione a marca</option>' +
            data.marcas.map(m => `<option value="${m.codigo}" data-nome="${m.nome}">${m.nome}</option>`).join('');

    } catch (err) {
        console.error('Falha ao carregar marcas:', err);
        selectMarca.innerHTML = '<option value="">Erro ao carregar marcas</option>';
    }
}

// Carrega os modelos quando a marca muda 
selectMarca.addEventListener('change', async () => {
    const codigoMarca = selectMarca.value;

    selectModelo.disabled = true;
    selectModelo.innerHTML = '<option value="">Carregando modelos...</option>';

    if (!codigoMarca) {
        selectModelo.innerHTML = '<option value="">Selecione a marca primeiro</option>';
        return;
    }

    try {
        const resp = await fetch(`${URL_MODELOS}?marca=${encodeURIComponent(codigoMarca)}`);
        const data = await resp.json();

        if (!data.success) {
            selectModelo.innerHTML = '<option value="">Erro ao carregar modelos</option>';
            return;
        }

        selectModelo.innerHTML = '<option value="">Selecione o modelo</option>' +
            data.modelos.map(m => `<option value="${m.nome}">${m.nome}</option>`).join('');
        selectModelo.disabled = false;

    } catch (err) {
        console.error('Falha ao carregar modelos:', err);
        selectModelo.innerHTML = '<option value="">Erro ao carregar modelos</option>';
    }
});

carregarMarcas();

formCarro.addEventListener('submit', async (e) => {
    e.preventDefault();

    const erroEl = document.querySelector('.error-msg-carro');
    erroEl.textContent = '';

    if (!selectMarca.value) {
        erroEl.textContent = 'Selecione a marca.';
        return;
    }

    if (!selectModelo.value) {
        erroEl.textContent = 'Selecione o modelo.';
        return;
    }

    const btn = document.getElementById('btnSalvarCarro');
    btn.disabled = true;
    btn.textContent = 'Salvando...';

    try {
        const formData = new FormData(formCarro);

        // envia o nome da marca para salvar
        const nomeMarca = selectMarca.options[selectMarca.selectedIndex].dataset.nome;
        formData.set('marca', nomeMarca);

        const resp = await fetch(URL_CADASTRAR_CARRO, {
            method: 'POST',
            body: formData
        });

        if (!resp.ok) {
            throw new Error('HTTP ' + resp.status);
        }

        const data = await resp.json();

        if (!data.success) {
            erroEl.textContent = data.errors.join(' ');
            return;
        }

        window.location.href = '<?php echo $url_base; ?>/index.php?secao=perfil';

    } catch (err) {
        console.error('Falha ao cadastrar carro:', err);
        erroEl.textContent = 'Erro ao salvar o carro. Tente novamente.';
    } finally {
        btn.disabled = false;
        btn.textContent = 'Salvar Carro';
    }
});
</script>