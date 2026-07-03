<?php if(empty($_SESSION['usuario'])){ ?>
<div class="container py-5">
    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0">
                <div class="card-body p-5">

                    <h2 class="mb-4">Entrar</h2>

                    <form id="formLogin" novalidate>

                        <input type="email"
                               class="form-control form-control-lg"
                               name="email"
                               placeholder="E-mail">

                        <input type="password"
                               class="form-control form-control-lg mt-3"
                               name="senha"
                               placeholder="Senha">

                        <div class="invalid-feedback d-block error-msg-login"></div>

                        <button type="submit" class="btn btn-primary mt-4" id="btnLogin">
                            Entrar
                        </button>

                        <a href="index.php?secao=cadastro" class="btn btn-link mt-4">
                            Ainda não tem conta? Cadastre-se
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>
<?php } else { ?>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="alert alert-success text-center" role="alert">
                    Você já está logado como <?php echo htmlspecialchars($_SESSION['user_nome']); ?>.
                </div>
            </div>
        </div>
    </div>
<?php } ?>    
<script>
const formLogin = document.getElementById('formLogin');

const URL_LOGIN       = 'includes/ajax/login.php';

formLogin.addEventListener('submit', async (e) => {
    e.preventDefault();

    const erroEl = document.querySelector('.error-msg-login');
    erroEl.textContent = '';

    const btnLogin = document.getElementById('btnLogin');
    btnLogin.disabled = true;
    btnLogin.textContent = 'Entrando...';

    try {
        const formData = new FormData(formLogin);

        const resp = await fetch(URL_LOGIN, {
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

        window.location.href = data.redirect || 'index.php';

    } catch (err) {
        console.error('Falha ao entrar:', err);
        erroEl.textContent = 'Erro ao entrar. Tente novamente.';
    } finally {
        btnLogin.disabled = false;
        btnLogin.textContent = 'Entrar';
    }
});
</script>