<div class="container py-5">
    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0">
                <div class="card-body p-5">

                    <form id="formCadastro" novalidate>

                        <div class="step active" data-step="1">
                            <h2>Como você se chama?</h2>

                            <input type="text"
                                   class="form-control form-control-lg mt-4"
                                   name="nome">
                            <div class="invalid-feedback d-block error-msg" data-error-for="1"></div>

                            <button type="button"
                                    class="btn btn-primary mt-4 btn-next">
                                Próximo
                            </button>
                        </div>

                        <div class="step d-none" data-step="2">
                            <h2>Qual seu e-mail?</h2>

                            <input type="email"
                                   class="form-control form-control-lg mt-4"
                                   name="email">
                            <div class="invalid-feedback d-block error-msg" data-error-for="2"></div>

                            <div class="mt-4">
                                <button type="button" class="btn btn-light btn-prev">
                                    Voltar
                                </button>

                                <button type="button" class="btn btn-primary btn-next">
                                    Próximo
                                </button>
                            </div>
                        </div>

                        <div class="step d-none" data-step="3">
                            <h2>Crie sua senha</h2>

                            <input type="password"
                                   class="form-control form-control-lg mt-4"
                                   name="senha"
                                   placeholder="Senha">
                            <small class="text-muted d-block mt-1">
                                Mínimo 8 caracteres, com letra maiúscula, minúscula e número.
                            </small>

                            <input type="password"
                                   class="form-control form-control-lg mt-3"
                                   name="confirmar_senha"
                                   placeholder="Confirme a senha">

                            <div class="invalid-feedback d-block error-msg" data-error-for="3"></div>

                            <div class="mt-4">
                                <button type="button" class="btn btn-light btn-prev">
                                    Voltar
                                </button>

                                <button type="submit" class="btn btn-success" id="btnFinalizar">
                                    Finalizar Cadastro
                                </button>
                            </div>
                        </div>

                    </form>

                    <div id="mensagemFinal" class="mt-4"></div>

                </div>
            </div>

        </div>

    </div>
</div>

<script>
let etapaAtual = 0;

const etapas = document.querySelectorAll('.step');
const form = document.getElementById('formCadastro');

// Caminhos relativos à URL da página (http://localhost/CarroVeio/index.php)
const URL_CHECK_EMAIL = 'includes/ajax/check_email.php';
const URL_REGISTER    = 'includes/ajax/user_register.php';

function mostrarErro(etapaNum, msg) {
    const el = document.querySelector(`.error-msg[data-error-for="${etapaNum}"]`);
    el.textContent = msg;
}

function limparErro(etapaNum) {
    mostrarErro(etapaNum, '');
}

function irParaEtapa(novaEtapa) {
    etapas[etapaAtual].classList.add('d-none');
    etapaAtual = novaEtapa;
    etapas[etapaAtual].classList.remove('d-none');
}

// ---------------- Botões "Voltar" ----------------
document.querySelectorAll('.btn-prev').forEach(btn => {
    btn.addEventListener('click', () => {
        irParaEtapa(etapaAtual - 1);
    });
});

// ---------------- Botões "Próximo" ----------------
document.querySelectorAll('.btn-next').forEach(btn => {
    btn.addEventListener('click', async () => {
        const passoAtualEl = etapas[etapaAtual];
        const passo = parseInt(passoAtualEl.dataset.step);

        limparErro(passo);

        // Etapa 1: nome
        if (passo === 1) {
            const nome = passoAtualEl.querySelector('[name="nome"]').value.trim();
            if (nome === '') {
                mostrarErro(1, 'Informe seu nome.');
                return;
            }
            irParaEtapa(etapaAtual + 1);
            return;
        }

        // Etapa 2: email (formato + verificação de duplicidade via AJAX)
        if (passo === 2) {
            const email = passoAtualEl.querySelector('[name="email"]').value.trim();
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regexEmail.test(email)) {
                mostrarErro(2, 'Digite um e-mail válido.');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Verificando...';

            try {
                const resp = await fetch(URL_CHECK_EMAIL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ email })
                });

                if (!resp.ok) {
                    throw new Error('HTTP ' + resp.status);
                }

                const data = await resp.json();

                if (!data.valid) {
                    mostrarErro(2, data.message);
                    return;
                }

                irParaEtapa(etapaAtual + 1);
            } catch (err) {
                console.error('Falha ao verificar e-mail:', err);
                mostrarErro(2, 'Erro ao verificar e-mail. Tente novamente.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Próximo';
            }
            return;
        }
    });
});

// ---------------- Envio final ----------------
form.addEventListener('submit', async (e) => {
    e.preventDefault();

    limparErro(3);

    const senha = form.querySelector('[name="senha"]').value;
    const confirmarSenha = form.querySelector('[name="confirmar_senha"]').value;

    const regraSenha = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

    if (!regraSenha.test(senha)) {
        mostrarErro(3, 'A senha precisa ter no mínimo 8 caracteres, com letra maiúscula, minúscula e número.');
        return;
    }

    if (senha !== confirmarSenha) {
        mostrarErro(3, 'As senhas não conferem.');
        return;
    }

    const btnFinalizar = document.getElementById('btnFinalizar');
    btnFinalizar.disabled = true;
    btnFinalizar.textContent = 'Enviando...';

    try {
        const formData = new FormData(form);

        const resp = await fetch(URL_REGISTER, {
            method: 'POST',
            body: formData
        });

        if (!resp.ok) {
            throw new Error('HTTP ' + resp.status);
        }

        const data = await resp.json();

        if (!data.success) {
            mostrarErro(3, data.errors.join(' '));
            return;
        }

        document.getElementById('mensagemFinal').innerHTML =
            `<div class="alert alert-success">${data.message} Redirecionando...</div>`;

        setTimeout(() => {
            window.location.href = data.redirect || 'index.php';
        }, 1000);

    } catch (err) {
        console.error('Falha ao cadastrar:', err);
        mostrarErro(3, 'Erro ao cadastrar. Tente novamente.');
    } finally {
        btnFinalizar.disabled = false;
        btnFinalizar.textContent = 'Finalizar Cadastro';
    }
});
</script>