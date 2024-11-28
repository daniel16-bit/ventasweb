<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
<!-- Modal para Confirmar Eliminación 
<div class="modal" id="confirmar-delete" tabindex="-1" aria-labelledby="confirmar-delete-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmar-delete-label">¿Estás seguro de que deseas eliminar este cliente?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <!-- Botón para cerrar el modal 
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- Enlace para eliminar el cliente
                <a href="#" class="btn btn-danger btn-ok">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Cuando se abre el modal, capturamos el ID del cliente y lo pasamos al enlace de eliminación
    const modal = document.getElementById('confirmar-delete');
    modal.addEventListener('show.bs.modal', function (event) {
        // Obtener el botón que abrió el modal (el que contiene el ID del cliente)
        const button = event.relatedTarget;
        const idCliente = button.getAttribute('data-id'); // Obtener el ID del cliente desde el atributo data-id

        // Cambiar el href del botón de "Eliminar" para que apunte al archivo de eliminación con el ID del cliente
        const deleteButton = modal.querySelector('.btn-ok');
        deleteButton.setAttribute('href', 'eliminar_cliente.php?id=' + idCliente);
    });
</script>


</body>
</html>