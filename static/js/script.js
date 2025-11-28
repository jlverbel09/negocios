$(document).ready(function () {
    redireccion('dashboard')
    //redireccion('usuarios')
    //redireccion('negocio', { 'negocio': 'MI COTITA', 'id': 1 })

})
/* REDIRECCIONAMIENTO DE RUTAS  */
function redireccion(ruta, data = {}) {
    $('.sidebar-item').removeClass('active')
    setTimeout(() => {
        $('#' + ruta + 'Menu').addClass('active')
    }, 100);
    $('#contenedor').html('')
    $.ajax({
        type: "GET",
        url: '../services/' + ruta + '.php',
        data: data,
        dataType: "html",
        success: function (respuesta) {
            $('#contenedor').html(respuesta)
            if (ruta == 'usuarios') {
                listUsuarios()
            }
            if (ruta == 'negocio') {
                $('#' + ruta + 'Menu' + data.id).addClass('active')

                listarProductos(data.id)
                //listarClientes(data.id)
                //listarPedidos(data.id)
                //listarVentas(data.id)
                //listarEstadisticas(data.id)
                //listarApis(data.id)
            }
        }
    });
}

/* USUARIOS */

function listUsuarios() {
    $('#contenedor').html('')
    $.ajax({
        type: "GET",
        url: '../services/usuarios.php?accion=listUsuarios',
        data: {},
        dataType: "html",
        success: function (respuesta) {
            $('#contenedor').html(respuesta)
            listRoles()
        }
    });
}

function eliminarUsuario(id) {
    if ($('#id_negocio_global').val()) {
        id_negocio_global = $('#id_negocio_global').val();
    } else {
        id_negocio_global = 0
    }
    $.ajax({
        type: "POST",
        url: '../services/usuarios.php?accion=eliminarUsuario',
        data: { id: id },
        dataType: "html",
        success: function (respuesta) {
            if (respuesta == 1) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Usuario eliminado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });

            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Error al eliminar el usuario',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            if (id_negocio_global != 0) {
                listarClientes(id_negocio_global)
            } else {
                $('#contenedor').html('')
                listUsuarios()
            }
        }
    });
}

function guardarUsuario() {

    var id = $('#id_usuario').val();
    var nombre = $('#nombre').val();
    var correo = $('#correo').val();
    var usuario = $('#usuario').val();
    var password = $('#password').val();
    var rol = $('#rol').val();
    var estado = $('#estado').val();

    if ($('#id_negocio_global').val()) {
        id_negocio_global = $('#id_negocio_global').val();
    } else {
        id_negocio_global = 0
    }

    $.ajax({
        type: "POST",
        url: '../services/usuarios.php?accion=guardarUsuario&id_negocio_global=' + id_negocio_global,
        data: { id: id, nombre: nombre, correo: correo, usuario: usuario, password: password, rol: rol, estado: estado },
        dataType: "html",
        success: function (respuesta) {
            if (id != '') {
                mensaje = "Usuario modificado correctamente";
            } else {
                mensaje = "usuario registrado correctamente";
            }
            if (respuesta == 1) {
                $('.cerrarModal').click()
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: mensaje,
                    showConfirmButton: false,
                    timer: 1500
                });

                if (id_negocio_global != 0) {
                    listarClientes(id_negocio_global)
                } else {
                    listUsuarios()
                }



            } else {
                $('#contenedor').html(respuesta)
            }

        }
    });
}

function editarUsuario(id) {

    $.ajax({
        type: "POST",
        url: '../services/usuarios.php?accion=editarUsuario',
        data: { id: id },
        dataType: "html",
        success: function (respuesta) {
            $('#modalUsuario').html(respuesta)
            $('#modalUsuario').modal('show')

        }
    });

}

/* SELECTS  */
function listRoles(id = '') {
    $('#rol').html('')
    $.ajax({
        type: "GET",
        url: '../services/selects.php?accion=listRoles',
        data: { id: id },
        dataType: "html",
        success: function (respuesta) {
            $('#rol').html(respuesta)
        }
    });
}
function listSelectUsuarios(idNegocio = 0, idCliente = 0, isAdmin = 0) {
    $('.listSelectUsuarios').html('')
    $.ajax({
        type: "GET",
        url: '../services/selects.php?accion=listSelectUsuarios',
        data: { idNegocio: idNegocio, idCliente: idCliente, isAdmin: isAdmin },
        dataType: "html",
        success: function (respuesta) {
            $('.listSelectUsuarios').html(respuesta)
        }
    });
}
function listSelectProducto(idNegocio = 0, idProducto = 0) {
    $('.listSelectProducto').html('')
    $.ajax({
        type: "GET",
        url: '../services/selects.php?accion=listSelectProducto',
        data: { idNegocio: idNegocio, idProducto: idProducto },
        dataType: "html",
        success: function (respuesta) {
            $('.listSelectProducto').html(respuesta)
        }
    });
}
function listSelectEstadoPedido(idNegocio = 0, idEstadoProducto = 0) {
    $('.listSelectEstadoPedido').html('')
    $.ajax({
        type: "GET",
        url: '../services/selects.php?accion=listSelectEstadoPedido',
        data: { idNegocio: idNegocio, idEstadoProducto: idEstadoProducto },
        dataType: "html",
        success: function (respuesta) {
            $('.listSelectEstadoPedido').html(respuesta)
        }
    });
}

/* NEGOCIOS */
function listarProductos(idnegocio) {
    $('.menu').removeClass('seleccionado')
    $('.btnproductos').addClass('seleccionado')
    $('#contenido-seccion').html('')
    $.ajax({
        type: "GET",
        url: './../services/productos.php?accion=listarProductos&idnegocio=' + idnegocio,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            $('#contenido-seccion').html(respuesta)
        }
    });
}

function visualizar(idproducto) {
    $('#vitapreviaproducto').html('')
    $.ajax({
        type: "GET",
        url: '../services/vistapreviaproducto.php?idproducto=' + idproducto,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            $('#vitapreviaproducto').html(respuesta)
        }
    });
}

/* CLIENTES */
function listarClientes(idnegocio) {
    $('.menu').removeClass('seleccionado')
    $('.btnclientes').addClass('seleccionado')

    $('#contenido-seccion').html('')
    $.ajax({
        type: "GET",
        url: '../services/clientes.php?accion=listarClientes&idnegocio=' + idnegocio,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            $('#contenido-seccion').html(respuesta)
            listRoles()
        }
    });
}

function soloClientes() {
    listRoles(3)
    $('#rol').attr('disabled', true)
}


/* ESTADISTICAS */
function listarEstadisticas(idnegocio) {
    $('.menu').removeClass('seleccionado')
    $('.btnEstadisticas').addClass('seleccionado')

    $('#contenido-seccion').html('')
    $.ajax({
        type: "GET",
        url: '../services/estadisticas.php?accion=listarEstadisticas&idnegocio=' + idnegocio,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            $('#contenido-seccion').html(respuesta)
        }
    });
}

/* PEDIDOS */
function listarPedidos(idnegocio) {
    $('.menu').removeClass('seleccionado')
    $('.btnPedidos').addClass('seleccionado')

    $('#contenido-seccion').html('')
    $.ajax({
        type: "GET",
        url: '../services/pedidos.php?accion=listarPedidos&idnegocio=' + idnegocio,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            $('#contenido-seccion').html(respuesta)
        }
    });
}

/* VENTAS */
function listarVentas(idnegocio) {
    $('.menu').removeClass('seleccionado')
    $('.btnVentas').addClass('seleccionado')

    $('#contenido-seccion').html('')
    $.ajax({
        type: "GET",
        url: '../services/ventas.php?accion=listarVentas&idnegocio=' + idnegocio,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            $('#contenido-seccion').html(respuesta)
        }
    });
}

/* APIS */
function listarApis(idnegocio) {
    $('.menu').removeClass('seleccionado')
    $('.btnApis').addClass('seleccionado')

    $('#contenido-seccion').html('')
    $.ajax({
        type: "GET",
        url: '../services/apis.php?accion=listarApis&idnegocio=' + idnegocio,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            $('#contenido-seccion').html(respuesta)
        }
    });
}


/* MODALES -------------------------------------------------------------------------*/
/* Modal producto */
function guardarProducto() {
    var nombreProducto = $('#nombreProducto').val()
    var precioProducto = $('#precioProducto').val()
    var promocionProducto = $('#promocionProducto').val()
    var categoriaProducto = $('#categoriaProducto').val()
    var descripcionProducto = $('#descripcionProducto').val()
    var imagenProducto = $('#imagenProducto').val()
    var idnegocio = $('#idNegocio').val()
    var idProducto = $('#idProducto').val()

    $.ajax({
        type: "POST",
        url: '../services/productos.php?accion=saveProductos&idnegocio=' + idnegocio,
        data: {
            nombreProducto: nombreProducto,
            precioProducto: precioProducto,
            promocionProducto: promocionProducto,
            categoriaProducto: categoriaProducto,
            descripcionProducto: descripcionProducto,
            imagenProducto: imagenProducto,
            idnegocio: idnegocio,
            idProducto: idProducto,
        },
        dataType: "html",
        success: function (respuesta) {
            if (idProducto != '') {
                mensaje = "Producto modificado correctamente";
            } else {
                mensaje = "Producto registrado correctamente";
            }
            $('.cerrarModal').click()
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            listarProductos(idnegocio)

        }
    });
}
function cargarModalProducto(idProducto) {

    $.ajax({
        type: "GET",
        url: './../services/productos.php?accion=cargarModalProducto&idproducto=' + idProducto,
        data: {},
        dataType: "json",
        success: function (respuesta) {
            $('#idProducto').val(respuesta.id)
            $('#nombreProducto').val(respuesta.nombre)
            $('#precioProducto').val(respuesta.precio)
            $('#promocionProducto').val(respuesta.promocion)
            $('#categoriaProducto').val(respuesta.categoria)
            $('#imagenProducto').val(respuesta.img_url)
            $('#descripcionProducto').val(respuesta.descripcion)

        }
    });
}
function eliminarProducto(idProducto) {
    var idnegocio = $('#idNegocio').val()
    $('#contenido-seccion').html('')

    $.ajax({
        type: "GET",
        url: '../services/productos.php?accion=eliminarProducto&idproducto=' + idProducto,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            if (respuesta == 1) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Producto eliminado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });

            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Error al eliminar el producto',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            listarProductos(idnegocio)
        }
    });
}

/* Modal Pedidos */
function guardarPedido() {
    var idNegocio = $('#idNegocio').val()
    var idPedido = $('#idPedido').val()
    var clientePedido = $('#clientePedido').val()
    var productoPedido = $('#productoPedido').val()
    var descripcionPedido = $('#descripcionPedido').val()
    var fechaentregaPedido = $('#fechaentregaPedido').val()
    var estadoPedido = $('#estadoPedido').val()
    var cantidadPedido = $('#cantidadPedido').val()
    var direccionPedido = $('#direccionPedido').val()


    $.ajax({
        type: "POST",
        url: '../services/pedidos.php?accion=savePedidos&idnegocio=' + idNegocio,
        data: {
            idNegocio: idNegocio,
            idPedido: idPedido,
            clientePedido: clientePedido,
            productoPedido: productoPedido,
            descripcionPedido: descripcionPedido,
            fechaentregaPedido: fechaentregaPedido,
            estadoPedido: estadoPedido,
            cantidadPedido: cantidadPedido,
            direccionPedido: direccionPedido
        },
        dataType: "html",
        success: function (respuesta) {
            if (idPedido != '') {
                mensaje = "Pedido modificado correctamente";
            } else {
                mensaje = "Pedido registrado correctamente";
            }
            $('.cerrarModal').click()
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            listarPedidos(idNegocio)

        }
    });
}
function cargarModalPedido(idPedido) {
    $.ajax({
        type: "GET",
        url: '../services/pedidos.php?accion=cargarModalPedido&idPedido=' + idPedido,
        data: {},
        dataType: "json",
        success: function (respuesta) {

            listSelectUsuarios(respuesta.id_negocio, respuesta.id_cliente)
            listSelectProducto(respuesta.id_negocio, respuesta.id_producto)
            listSelectEstadoPedido(respuesta.id_negocio, respuesta.id_estado)

            $('#idPedido').val(respuesta.id)
            $('#clientePedido').val(respuesta.id_cliente)
            $('#productoPedido').val(respuesta.id_producto)
            $('#descripcionPedido').val(respuesta.mensaje)
            $('#fechaentregaPedido').val(respuesta.fecha_entrega)
            $('#estadoPedido').val(respuesta.id_estado)
            $('#cantidadPedido').val(respuesta.cantidad)
            $('#direccionPedido').val(respuesta.direccion)

        }
    });
}
function eliminarPedido(idPedido, pantalla = 'pedidos') {
    var idnegocio = $('#idNegocio').val()
    $('#contenido-seccion').html('')

    $.ajax({
        type: "GET",
        url: '../services/pedidos.php?accion=eliminarPedido&idPedido=' + idPedido,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            if (respuesta == 1) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Pedido eliminado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });

            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Error al eliminar el Pedido',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            if (pantalla == 'pedidos') {
                listarPedidos(idnegocio)
            } else {
                listarVentas(idnegocio)
            }

        }
    });
}


/* INVERSION */
function guardarInversion() {
    var valorInvertir = $('#valorInvertir').val()
    var idNegocio = $('#id_negocio_global').val()
    $.ajax({
        type: "POST",
        url: '../services/inversion.php?accion=guardarInversion',
        data: { valorInvertir: valorInvertir, idNegocio: idNegocio },
        dataType: "html",
        success: function (respuesta) {
            if (respuesta == 1) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Inversion guardada correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });

            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Error al realizar la inversion',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            $('#valorInvertir').val('')
            cargarInversion()
        }
    });

}
function cargarInversion() {
    var idNegocio = $('#id_negocio_global').val()
    $.ajax({
        type: "GET",
        url: '../services/inversion.php?accion=cargarInversion&idNegocio=' + idNegocio,
        data: {},
        dataType: "html",
        success: function (respuesta) {

            $('#valorInvertido').html(respuesta)
        }
    });
}
function cargarHistorialInversion() {
    var idNegocio = $('#id_negocio_global').val()
    $.ajax({
        type: "GET",
        url: '../services/inversion.php?accion=cargarHistroialInversion&idNegocio=' + idNegocio,
        data: {},
        dataType: "html",
        success: function (respuesta) {

            $('#listaHistorial').html(respuesta)
        }
    });
}
function eliminarInversion(idInversion){
    $.ajax({
        type: "GET",
        url: '../services/inversion.php?accion=eliminarInversion&idInversion=' + idInversion,
        data: {},
        dataType: "html",
        success: function (respuesta) {
            if (respuesta == 1) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Inversion eliminada correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });

            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Error al eliminar la inversion',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            cargarInversion()
             $('.cerrarModal').click()

        }
    });
}

/* NEGOCIO */
function cargarNegocio(idMiNegocio) {
    $.ajax({
        type: "GET",
        url: './../services/minegocio.php?accion=detallesNegocio&idMiNegocio=' + idMiNegocio,
        data: {},
        dataType: "json",
        success: function (respuesta) {
            $('#idMiNegocio').val(idMiNegocio)
            $('#nombreNegocio').val(respuesta.nombre)
            $('#estadoNegocio').val(respuesta.estado)
            $('#sloganNegocio').val(respuesta.slogan)
            listSelectUsuarios(0, respuesta.administrador, 2)
            $('#temaNegocio').val(respuesta.tema)
            $('#wpNegocio').val(respuesta.whatsapp)
            $('#facebookNegocio').val(respuesta.facebook)
            $('#igNegocio').val(respuesta.instagram)
            $('#ubicacionNegocio').val(respuesta.ubicacion)
            $('#correoNegocio').val(respuesta.correo)

        }
    });
}
function GuardardetallesNegocio() {
    var idMiNegocio = $('#idMiNegocio').val()
    var nombreNegocio = $('#nombreNegocio').val()
    var estadoNegocio = $('#estadoNegocio').val()
    var sloganNegocio = $('#sloganNegocio').val()
    var administradorNegocio = $('#administradorNegocio').val()
    var temaNegocio = $('#temaNegocio').val()
    var wpNegocio = $('#wpNegocio').val()
    var facebookNegocio = $('#facebookNegocio').val()
    var igNegocio = $('#igNegocio').val()
    var ubicacionNegocio = $('#ubicacionNegocio').val()
    var correoNegocio = $('#correoNegocio').val()

    data = {
        idMiNegocio: idMiNegocio,
        nombreNegocio: nombreNegocio,
        estadoNegocio: estadoNegocio,
        sloganNegocio: sloganNegocio,
        administradorNegocio: administradorNegocio,
        temaNegocio: temaNegocio,
        wpNegocio: wpNegocio,
        facebookNegocio: facebookNegocio,
        igNegocio: igNegocio,
        ubicacionNegocio: ubicacionNegocio,
        correoNegocio: correoNegocio
    }
    $.ajax({
        type: "POST",
        url: '../services/minegocio.php?accion=GuardardetallesNegocio',
        data: data,
        dataType: "html",
        success: function (respuesta) {
            if (respuesta == 1) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Datos del negocio actualizados correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('.cerrarModal').click()
            } else {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Error al guardar los datos',
                    showConfirmButton: false,
                    timer: 1500
                });
            }

        }
    });
}