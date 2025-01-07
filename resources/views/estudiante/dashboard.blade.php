@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Dashboard Estudiante - PIDE/RENIEC</h1>
    <p>Demostración: Actualizar Credencial + Consulta de DNI de forma Dinámica</p>

    <!-- ======================================= -->
    <!-- FORMULARIO: ACTUALIZAR CREDENCIAL PIDE -->
    <!-- ======================================= -->
    <div class="card mb-5">
        <div class="card-header bg-primary text-white">
            <h4>Actualizar Credencial</h4>
        </div>
        <div class="card-body">
            <form id="frmActualizar" method="POST" onsubmit="return false;">
                @csrf
                <div class="mb-3">
                    <label for="credencialAnterior" class="form-label">Credencial Anterior</label>
                    <input type="text" id="credencialAnterior" name="credencialAnterior" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="credencialNueva" class="form-label">Nueva Credencial</label>
                    <input type="text" id="credencialNueva" name="credencialNueva" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nuDni" class="form-label">DNI (Usuario)</label>
                    <input type="text" id="nuDni" name="nuDni" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nuRuc" class="form-label">RUC de la Entidad</label>
                    <input type="text" id="nuRuc" name="nuRuc" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </form>

            <!-- Aquí mostraremos mensajes de éxito o error -->
            <div id="resultadoActualizar" class="mt-3"></div>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- FORMULARIO: CONSULTAR DATOS POR DNI PIDE -->
    <!-- ========================================== -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h4>Consultar Datos Ciudadano</h4>
        </div>
        <div class="card-body">
            <form id="frmConsultar" method="POST" onsubmit="return false;">
                @csrf
                <div class="mb-3">
                    <label for="nuDniConsulta" class="form-label">DNI a Consultar</label>
                    <input type="text" id="nuDniConsulta" name="nuDniConsulta" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nuDniUsuario" class="form-label">Tu DNI (Usuario)</label>
                    <input type="text" id="nuDniUsuario" name="nuDniUsuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nuRucUsuario" class="form-label">RUC de la Entidad</label>
                    <input type="text" id="nuRucUsuario" name="nuRucUsuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña PIDE</label>
                    <input type="text" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-info">Consultar</button>
            </form>

            <!-- Aquí se mostrará el resultado de la consulta -->
            <div id="resultadoConsulta" class="mt-3"></div>
        </div>
    </div>
</div>

<!-- Script para manejar ambos formularios con fetch -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    /* =================================================
       1. ACTUALIZAR CREDENCIAL (frmActualizar)
       ================================================= */
    const frmActualizar = document.getElementById('frmActualizar');
    const divActualizar = document.getElementById('resultadoActualizar');

    frmActualizar.addEventListener('submit', function(e) {
        e.preventDefault();

        // Limpiamos resultados previos
        divActualizar.innerHTML = "";

        let formData = new FormData(frmActualizar);
        
        fetch("{{ route('reniec.actualizar') }}", {
            method: 'POST',
            body: formData
        })
        .then(resp => resp.json())
        .then(json => {
            console.log("Actualizar JSON:", json);

            if (json.error) {
                // Error del servidor (excepción, etc.)
                divActualizar.innerHTML = `
                    <div class="alert alert-danger">
                      <strong>Error:</strong> ${json.error}
                    </div>`;
                return;
            }

            // Asumimos que en json.data vendrán coResultado, deResultado
            if (json.data && json.data.coResultado) {
                let coRes = json.data.coResultado;
                let deRes = json.data.deResultado || 'Sin descripción';

                if (coRes === '0000') {
                    // Éxito → Mostrar alerta verde
                    divActualizar.innerHTML = `
                        <div class="alert alert-success">
                          <strong>¡Credencial actualizada!</strong> 
                          <br> Mensaje: ${deRes}
                          <br> Ahora tu credencial está activa y configurada correctamente.
                        </div>`;
                } else {
                    // Algún error (clave no actualizada, etc.)
                    divActualizar.innerHTML = `
                        <div class="alert alert-warning">
                          <strong>Atención:</strong> [${coRes}] ${deRes}
                        </div>`;
                }
            } else {
                // Estructura distinta
                divActualizar.innerHTML = `
                    <div class="alert alert-danger">
                      <strong>No se encontró coResultado en la respuesta</strong>
                    </div>`;
            }
        })
        .catch(err => {
            console.error(err);
            divActualizar.innerHTML = `
                <div class="alert alert-danger">
                  <strong>Error de conexión:</strong> ${err}
                </div>`;
        });
    });


    /* =================================================
       2. CONSULTAR DATOS (frmConsultar)
       ================================================= */
    const frmConsultar = document.getElementById('frmConsultar');
    const divConsulta  = document.getElementById('resultadoConsulta');

    frmConsultar.addEventListener('submit', function(e) {
        e.preventDefault();

        divConsulta.innerHTML = "";

        let formData = new FormData(frmConsultar);

        fetch("{{ route('reniec.consultar') }}", {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(json => {
            console.log("Consultar JSON:", json);
            renderConsulta(json);
        })
        .catch(error => {
            console.error("Error en fetch:", error);
            divConsulta.innerHTML = `<div class="alert alert-danger">Error de conexión: ${error}</div>`;
        });
    });

    function renderConsulta(json) {
        if (json.error) {
            divConsulta.innerHTML = `<div class="alert alert-danger"><strong>Error:</strong> ${json.error}</div>`;
            return;
        }

        if (json.data && json.data.consultarResponse) {
            let retorno = json.data.consultarResponse.return;
            if (!retorno) {
                divConsulta.innerHTML = `<div class="alert alert-danger">No se encontró "return" en la respuesta.</div>`;
                return;
            }

            let coResultado = retorno.coResultado;
            let deResultado = retorno.deResultado;
            let datosPersona = retorno.datosPersona;

            if (coResultado === "0000") {
                // Éxito
                let html = `
                    <div class="alert alert-success">
                        <h5>Consulta Exitosa</h5>
                        <p><strong>Código de Resultado:</strong> ${coResultado}</p>
                        <p><strong>Mensaje:</strong> ${deResultado}</p>
                `;

                if (datosPersona) {
                    let apPrimer    = datosPersona.apPrimer || '';
                    let apSegundo   = datosPersona.apSegundo || '';
                    let prenombres  = datosPersona.prenombres || '';
                    let direccion   = datosPersona.direccion || '';
                    let estadoCivil = datosPersona.estadoCivil || '';
                    let restriccion = datosPersona.restriccion || '';
                    let ubigeo      = datosPersona.ubigeo || '';
                    let fotoBase64  = datosPersona.foto || '';

                    html += `
                        <p><strong>Apellido Paterno:</strong> ${apPrimer}</p>
                        <p><strong>Apellido Materno:</strong> ${apSegundo}</p>
                        <p><strong>Nombres:</strong> ${prenombres}</p>
                        <p><strong>Dirección:</strong> ${direccion}</p>
                        <p><strong>Estado Civil:</strong> ${estadoCivil}</p>
                        <p><strong>Restricción:</strong> ${restriccion}</p>
                        <p><strong>Ubigeo:</strong> ${ubigeo}</p>
                    `;

                    // Mostrar foto
                    if (fotoBase64) {
                        html += `
                            <p><strong>Foto:</strong></p>
                            <div>
                                <img src="data:image/jpeg;base64,${fotoBase64}" 
                                     alt="Foto RENIEC"
                                     style="max-width:200px;">
                            </div>
                        `;
                    }

                    html += `</div>`; // Cerrar el alert
                }
                divConsulta.innerHTML = html;
            } else {
                // coResultado != "0000"
                divConsulta.innerHTML = `
                    <div class="alert alert-warning">
                      <strong>Atención:</strong> [${coResultado}] ${deResultado}
                    </div>`;
            }
        } else {
            divConsulta.innerHTML = `
                <div class="alert alert-danger">
                  No se encontró "consultarResponse" en la respuesta.
                </div>`;
        }
    }
});
</script>
@endsection
