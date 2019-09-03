<?php if(isset($_SESSION['aviso'])) { ?>
<!-- Aviso -->
<div class="row mt-2">
    <div class="toast mx-auto">
        <div class="toast-header">
            <div class="fa fa-check mr-2"></div>
            <strong class="mr-auto">
                <?php echo $_SESSION['aviso']; ?>
            </strong>
        </div>
    </div>
</div>
<?php } ?>

<!-- Alerta -->
<div id="alerta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="alertaTitulo" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="alertaCabecera" class="modal-header">
                <h5 id="alertaTitulo" class="modal-title">
                    Titulo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="alertaDescripcion" class="modal-body">
                Descripcion
            </div>
            <div class="modal-footer">
                <button type="button" id="botonConfirmarAlerta" class="btn btn-dark-metafx">
                    Confirmar
                </button>
                <button type="button" id="botonCerrarAlerta" class="btn btn-secondary">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>