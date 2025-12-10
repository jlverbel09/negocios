<!-- MODAL PRODUCTO-->
<div class="modal fade" id="modalProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Productos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <input type="hidden" id="idProducto" value="">
                    <label>Nombre</label>
                    <input type="text" value="" placeholder="Nombre" class="form-control" id="nombreProducto">
                </div>
                <div class="col-md-6">
                    <label>Precio</label>
                    <input type="number" required value="" placeholder="0.00" class="form-control" id="precioProducto">
                </div>
                <div class="col-md-6">
                    <label>Promoción</label>
                    <input type="number" value="" placeholder="0.00" class="form-control" id="promocionProducto">
                </div>
                <div class="col-md-6">
                    <label>Categoria</label>
                    <input type="text" placeholder="EJ: Tejido, postre, dulce, ropa, zapatos, etc " value="" class="form-control" id="categoriaProducto">
                </div>
                <div class="col-md-12">
                    <label>Imagen</label>
                    <input type="text" placeholder="Url" value="" class="form-control" id="imagenProducto">
                </div>
                <div class="col-md-12">
                    <label>Descripción</label>
                    <textarea class="form-control" rows="5" name="" id="descripcionProducto" placeholder="Detalle del producto"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarProducto()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL USUARIOS -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registro de Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6 ">
                    <input type="hidden" value="" id="id_usuario">

                    <label class="mb-1">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre">
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Correo Electrónico</label>
                    <input type="text" class="form-control" id="correo">
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Usuario</label>
                    <input type="text" class="form-control" id="usuario">
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Contraseña</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Rol</label>
                    <select class="form-select" name="rol" id="rol"></select>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Estado</label>
                    <select class="form-select" name="estado" id="estado">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarUsuario()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PEDIDOS-->
<div class="modal fade" id="modalPedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Pedidos & Ventas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <input type="hidden" class="form-control" value="" id="idPedido">
                    <label>Cliente</label>
                    <select class="form-select listSelectUsuarios" id="clientePedido"></select>
                </div>
                <div class="col-md-6">
                    <label>Producto</label>
                    <select class="form-select listSelectProducto" id="productoPedido"></select>
                </div>
                <div class="col-md-12">
                    <div id="vistaprevia"></div>
                </div>
                <div class="col-md-12">
                    <label>Mensaje</label>
                    <textarea class="form-control" rows="3" name="" id="descripcionPedido" placeholder="Mensaje con detalles para el producto"></textarea>
                </div>
                <div class="col-md-4">
                    <label>Fecha Entrega</label>
                    <input type="date" value="" class="form-control" id="fechaentregaPedido">
                </div>
                <div class="col-md-4">
                    <label>Estado</label>
                    <select class="form-select listSelectEstadoPedido" id="estadoPedido"></select>
                </div>
                <div class="col-md-4">
                    <label>Cantidad</label>
                    <select class="form-select" id="cantidadPedido">
                        <?php
                        for ($i = 1; $i <= 10; $i++) {
                        ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-12">
                    <label>Dirección</label>
                    <textarea class="form-control" rows="2" name="" id="direccionPedido" placeholder="Direcciòn y/o especificaciones para la entrega"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPedido()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL HISTORIAL INVERTIDO-->
<div class="modal fade" id="modalHistorial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Historial de Inversiones</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-12  text-white">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Fecha
                                </th>
                                <th>
                                    Valor
                                </th>
                                <th class="text-center">
                                    Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody id="listaHistorial"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL NEGOCIO-->
<div class="modal fade" id="modalNegocio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Mi Negocio</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <input type="hidden" class="form-control" value="" id="idMiNegocio">
                    <label>Nombre</label>
                    <input type="text" value="" class="form-control" id="nombreNegocio">
                </div>
                <div class="col-md-6">
                    <label>Producto</label>
                    <select class="form-select" id="estadoNegocio">
                        <option value="A">Activo</option>
                        <option value="I">Inactivo</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label>Slogan</label>
                    <textarea class="form-control" rows="2" name="" id="sloganNegocio" placeholder="Slogan descriptivo significativo del negocio"></textarea>
                </div>

                <div class="col-md-6">
                    <label>Administrador</label>
                    <select class="form-select listSelectUsuarios" id="administradorNegocio"></select>
                </div>
                <div class="col-md-6">
                    <label>Tema</label>
                    <input type="text" value="" class="form-control" id="temaNegocio">
                </div>
                <div class="col-md-6">
                    <label>Whatsapp</label>
                    <input type="text" value="" class="form-control" id="wpNegocio">
                </div>
                <div class="col-md-6">
                    <label>Facebook</label>
                    <input type="text" value="" class="form-control" id="facebookNegocio">
                </div>
                <div class="col-md-6">
                    <label>Instagram</label>
                    <input type="text" value="" class="form-control" id="igNegocio">
                </div>
                <div class="col-md-6">
                    <label>Ubicacion</label>
                    <input type="text" value="" class="form-control" id="ubicacionNegocio">
                </div>
                <div class="col-md-12">
                    <label>Correo Electronico</label>
                    <input type="text" value="" class="form-control" id="correoNegocio">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="GuardardetallesNegocio()">Guardar</button>
            </div>
        </div>
    </div>
</div>