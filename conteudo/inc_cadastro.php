<div class="container py-5">
    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow border-0">
                <div class="card-body p-5">

                    <form id="formCadastro">

                        <div class="step active" data-step="1">
                            <h2>Como você se chama?</h2>

                            <input type="text"
                                   class="form-control form-control-lg mt-4"
                                   name="nome">

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
                                   name="senha">

                            <div class="mt-4">
                                <button type="button" class="btn btn-light btn-prev">
                                    Voltar
                                </button>

                                <button type="submit" class="btn btn-success">
                                    Finalizar Cadastro
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>
</div>

<script>
    let etapaAtual = 0;

const etapas = document.querySelectorAll('.step');

document.querySelectorAll('.btn-next').forEach(btn => {
    btn.addEventListener('click', () => {

        etapas[etapaAtual].classList.add('d-none');

        etapaAtual++;

        etapas[etapaAtual].classList.remove('d-none');
    });
});

document.querySelectorAll('.btn-prev').forEach(btn => {
    btn.addEventListener('click', () => {

        etapas[etapaAtual].classList.add('d-none');

        etapaAtual--;

        etapas[etapaAtual].classList.remove('d-none');
    });
});
</script>