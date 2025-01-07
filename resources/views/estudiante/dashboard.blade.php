@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Consulta y Actualización de Credenciales (RENIEC - PIDE)</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- /Header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">

      <!-- Fila centrada con dos col-md-5 -->
      <div class="row justify-content-center" style="gap: 20px;">
        
        <!-- 1. Formulario ACTUALIZAR -->
        <div class="col-md-5">
          <div class="card">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Gestionar Credenciales</h3>
            </div>
            <div class="card-body">
              <form id="frmActualizar" onsubmit="return false;">
                @csrf
                <!-- Credencial Anterior con botón ojo -->
                <div class="form-group">
                  <label for="credencialAnterior">Credencial Actual:</label>
                  <div class="input-group">
                    <input type="password" id="credencialAnterior" name="credencialAnterior" class="form-control" required>
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button"
                              onclick="togglePassword('credencialAnterior','iconAnterior')">
                        <i id="iconAnterior" class="fa fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Nueva Credencial con botón ojo -->
                <div class="form-group">
                  <label for="credencialNueva">Nueva Credencial:</label>
                  <div class="input-group">
                    <input type="password" id="credencialNueva" name="credencialNueva" class="form-control" required minlength="8">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button"
                              onclick="togglePassword('credencialNueva','iconNueva')">
                        <i id="iconNueva" class="fa fa-eye"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- DNI y RUC -->
                <div class="form-group">
                  <label for="nuDni">DNI (Usuario):</label>
                  <input type="text" id="nuDni" name="nuDni" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="nuRuc">RUC de la Entidad:</label>
                  <input type="text" id="nuRuc" name="nuRuc" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary mt-2" style="width: 100%;">Actualizar Credencial</button>
              </form>

              <!-- Resultado de actualizar -->
              <div id="resultadoActualizar" class="mt-3"></div>
            </div>
          </div>
        </div>
        <!-- /Formulario ACTUALIZAR -->

        <!-- 2. Formulario CONSULTAR -->
        <div class="col-md-5">
          <div class="card">
            <div class="card-header bg-success text-white">
              <h3 class="card-title">Consulta de DNI</h3>
            </div>
            <div class="card-body">
              <form id="frmConsultar" onsubmit="return false;">
                @csrf
                <div class="form-group">
                  <label for="nuDniConsulta">DNI a Consultar:</label>
                  <input type="text" id="nuDniConsulta" name="nuDniConsulta" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="nuDniUsuario">Tu DNI (Usuario):</label>
                  <input type="text" id="nuDniUsuario" name="nuDniUsuario" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="nuRucUsuario">RUC de la Entidad:</label>
                  <input type="text" id="nuRucUsuario" name="nuRucUsuario" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="password">Contraseña PIDE:</label>
                  <input type="text" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success mt-2" style="width: 100%;">Consultar</button>
              </form>
              
              <!-- Resultado de consultar -->
              <div id="resultadoConsulta" class="mt-3"></div>
            </div>
          </div>
        </div>
        <!-- /Formulario CONSULTAR -->
      </div>

      <!-- Card de Resultados Generales (Opcional) abajo -->
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card mt-4">
            <div class="card-header bg-info text-white">
              <h3 class="card-title">Resultados Generales</h3>
            </div>
            <div class="card-body">
              <div id="resultadoGlobal"></div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /container-fluid -->
  </section>
</div><!-- /content-wrapper -->


<!-- Script JS -->
<script>
  // Toggle password (mostrar/ocultar)
  function togglePassword(inputId, iconId) {
    let input = document.getElementById(inputId);
    let icon  = document.getElementById(iconId);
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    /* =========================================================
       1. ACTUALIZAR CREDENCIAL (frmActualizar)
       ========================================================= */
    const frmActualizar = document.getElementById('frmActualizar');
    const divActualizar = document.getElementById('resultadoActualizar');

    frmActualizar.addEventListener('submit', function(e) {
      e.preventDefault();
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
          divActualizar.innerHTML = `
            <div class="alert alert-danger">
              <strong>Error:</strong> ${json.error}
            </div>`;
          return;
        }

        // Asumimos la estructura: { "data": { "coResultado":"0000", "deResultado":"..." } }
        let data = json.data || {};
        let coRes = data.coResultado;
        let deRes = data.deResultado;

        if (coRes) {
          if (coRes === '0000') {
            divActualizar.innerHTML = `
              <div class="alert alert-success">
                <strong>¡Credencial actualizada con éxito!</strong><br>
                ${deRes || 'Actualización realizada correctamente'}
              </div>`;
          } else {
            divActualizar.innerHTML = `
              <div class="alert alert-warning">
                <strong>Atención:</strong> [${coRes}] ${deRes || 'No se pudo actualizar la credencial'}
              </div>`;
          }
        } else {
          divActualizar.innerHTML = `
            <div class="alert alert-danger">
              <strong>No se encontró "coResultado" en la respuesta</strong>
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


    /* =========================================================
       2. CONSULTAR DNI (frmConsultar)
       ========================================================= */
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
        divConsulta.innerHTML = `
          <div class="alert alert-danger">
            <strong>Error de conexión:</strong> ${error}
          </div>`;
      });
    });

    function renderConsulta(json) {
      if (json.error) {
        divConsulta.innerHTML = `
          <div class="alert alert-danger">
            <strong>Error:</strong> ${json.error}
          </div>`;
        return;
      }
      
      // Estructura: { "data": { "coResultado": "0000", "deResultado":"...", "datosPersona": {...} } }
      let data = json.data || {};
      let coResultado  = data.coResultado;
      let deResultado  = data.deResultado;
      let datosPersona = data.datosPersona;

      if (coResultado === "0000") {
        let html = `
          <div class="alert alert-success">
            <h5>Consulta Exitosa</h5>
            <p><strong>Código de Resultado:</strong> ${coResultado}</p>
            <p><strong>Mensaje:</strong> ${deResultado}</p>
        `;

        if (datosPersona) {
          let apPrimer    = datosPersona.apPrimer    || 'N/A';
          let apSegundo   = datosPersona.apSegundo   || 'N/A';
          let prenombres  = datosPersona.prenombres  || 'N/A';
          let direccion   = datosPersona.direccion   || 'N/A';
          let estadoCivil = datosPersona.estadoCivil || 'N/A';
          let restriccion = datosPersona.restriccion || 'N/A';
          let ubigeo      = datosPersona.ubigeo      || 'N/A';
          let fotoBase64  = datosPersona.foto        || '';

          html += `
            <ul>
              <li><strong>Primer Apellido:</strong> ${apPrimer}</li>
              <li><strong>Segundo Apellido:</strong> ${apSegundo}</li>
              <li><strong>Nombres:</strong> ${prenombres}</li>
              <li><strong>Dirección:</strong> ${direccion}</li>
              <li><strong>Estado Civil:</strong> ${estadoCivil}</li>
              <li><strong>Ubigeo:</strong> ${ubigeo}</li>
              <li><strong>Restricción:</strong> ${restriccion}</li>
            </ul>
          `;

          if (fotoBase64) {
            html += `
              <div>
                <strong>Foto:</strong><br>
                <img src="data:image/jpeg;base64,${fotoBase64}" 
                     alt="Foto del DNI" style="max-width: 200px;">
              </div>
            `;
          }
        }

        html += `</div>`; // Cerrar alert
        divConsulta.innerHTML = html;

      } else {
        // coResultado != 0000 => error
        divConsulta.innerHTML = `
          <div class="alert alert-warning">
            <strong>Atención:</strong> [${coResultado}] ${deResultado}
          </div>`;
      }
    }

  });
</script>
@endsection





