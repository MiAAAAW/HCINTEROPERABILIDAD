@extends('layouts.app')

@section('content')
<div class="content-wrapper"><!-- AdminLTE pattern -->
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Consulta y Actualización de Credenciales (RENIEC - PIDE)</h1>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container">

      <!-- Notificaciones de éxito o error de Laravel (session) -->
      @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="alert alert-danger">
          {{ $errors->first() }}
        </div>
      @endif

      <!-- Formularios lado a lado (responsive) -->
      <div class="row" style="gap: 20px; align-items: stretch;">

        <!-- ================================
             1. Formulario ACTUALIZAR
           ================================ -->
        <div class="col-md-6">
          <div class="card" style="min-height: 300px;">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Gestionar Credenciales</h3>
            </div>
            <div class="card-body">
              <form id="frmActualizar" onsubmit="return false;">
                @csrf

                <!-- Credencial Actual -->
                <div class="form-group" style="position: relative;">
                  <label for="credencialAnterior">Credencial Actual:</label>
                  <input
                    type="password"
                    id="credencialAnterior"
                    name="credencialAnterior"
                    class="form-control"
                    required
                  >
                  <i
                    class="fas fa-eye"
                    id="toggleCredAnterior"
                    style="position: absolute; top: 35px; right: 15px; cursor: pointer;">
                  </i>
                </div>

                <!-- Nueva Credencial -->
                <div class="form-group" style="position: relative;">
                  <label for="credencialNueva">Nueva Credencial:</label>
                  <input
                    type="password"
                    id="credencialNueva"
                    name="credencialNueva"
                    class="form-control"
                    required
                    minlength="8"
                  >
                  <i
                    class="fas fa-eye"
                    id="toggleCredNueva"
                    style="position: absolute; top: 35px; right: 15px; cursor: pointer;">
                  </i>
                </div>

                <!-- DNI -->
                <div class="form-group">
                  <label for="nuDni">DNI (Usuario):</label>
                  <input
                    type="text"
                    id="nuDni"
                    name="nuDni"
                    class="form-control"
                    required
                  >
                </div>

                <!-- RUC (pre-llenado) -->
                <div class="form-group">
                  <label for="nuRuc">RUC de la Entidad:</label>
                  <input
                    type="text"
                    id="nuRuc"
                    name="nuRuc"
                    class="form-control"
                    required
                    value="20181438364"
                  >
                </div>

                <button
                  type="submit"
                  class="btn btn-primary mt-2 w-100"
                >
                  Actualizar Credencial
                </button>
              </form>

              <!-- Resultado de actualizar (solo 1 contenedor de alertas) -->
              <div id="resultadoActualizar" class="mt-3"></div>
            </div>
          </div>
        </div>

        <!-- ============================
             2. Formulario CONSULTAR
           ============================ -->
        <div class="col-md-6">
          <div class="card" style="min-height: 300px;">
            <div class="card-header bg-success text-white">
              <h3 class="card-title">Consulta de DNI</h3>
            </div>
            <div class="card-body">
              <form id="frmConsultar" onsubmit="return false;">
                @csrf

                <div class="form-group">
                  <label for="nuDniConsulta">DNI a Consultar:</label>
                  <input
                    type="text"
                    id="nuDniConsulta"
                    name="nuDniConsulta"
                    class="form-control"
                    required
                  >
                </div>

                <div class="form-group">
                  <label for="nuDniUsuario">Tu DNI (Usuario):</label>
                  <input
                    type="text"
                    id="nuDniUsuario"
                    name="nuDniUsuario"
                    class="form-control"
                    required
                  >
                </div>

                <div class="form-group">
                  <label for="nuRucUsuario">RUC de la Entidad:</label>
                  <input
                    type="text"
                    id="nuRucUsuario"
                    name="nuRucUsuario"
                    class="form-control"
                    required
                    value="20181438364"
                  >
                </div>

                <div class="form-group" style="position: relative;">
                  <label for="password">Contraseña PIDE:</label>
                  <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    required
                  >
                  <i
                    class="fas fa-eye"
                    id="togglePasswordPIDE"
                    style="position: absolute; top: 35px; right: 15px; cursor: pointer;">
                  </i>
                </div>

                <button
                  type="submit"
                  class="btn btn-success mt-2 w-100"
                >
                  Consultar
                </button>
              </form>

              <!-- Resultado de consulta (solo 1 contenedor de alertas) -->
              <div id="resultadoConsulta" class="mt-3"></div>
            </div>
          </div>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container -->
  </section>
</div><!-- /.content-wrapper -->
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
  // =======================================
  // A) Mostrar/Ocultar Contraseñas
  // =======================================
  const toggles = [
    { inputId: 'credencialAnterior', iconId: 'toggleCredAnterior' },
    { inputId: 'credencialNueva',    iconId: 'toggleCredNueva' },
    { inputId: 'password',           iconId: 'togglePasswordPIDE' }
  ];

  toggles.forEach(item => {
    const inputField = document.getElementById(item.inputId);
    const iconToggle = document.getElementById(item.iconId);

    if (inputField && iconToggle) {
      iconToggle.addEventListener('click', function() {
        const isPassword = inputField.type === 'password';
        inputField.type = isPassword ? 'text' : 'password';
        // Cambia ícono
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    }
  });


  // =======================================
  // B) ACTUALIZAR CREDENCIAL
  // =======================================
  const frmActualizar = document.getElementById('frmActualizar');
  const divActualizar = document.getElementById('resultadoActualizar');

  frmActualizar.addEventListener('submit', function(e) {
    e.preventDefault();
    divActualizar.innerHTML = ""; // Limpia alertas previas

    const formData = new FormData(frmActualizar);

    fetch("{{ route('reniec.actualizar') }}", {
      method: 'POST',
      body: formData
    })
    .then(resp => resp.json())
    .then(json => {
      console.log("Actualizar JSON:", json);

      if (json.error) {
        // Error grave (excepción, etc.)
        return showAlert(divActualizar, 'danger', 'Error', json.error);
      }

      // Verificamos si PIDE devolvió coResultado
      if (json.data && json.data.coResultado) {
        const coRes = json.data.coResultado;
        const deRes = json.data.deResultado || 'Sin descripción';

        // Caso de éxito
        if (coRes === '0000') {
          showAlert(divActualizar, 'success', '¡Credencial actualizada con éxito!', deRes);
        } else {
          // coRes != 0000 => error
          showAlert(divActualizar, 'danger', `Error [${coRes}]`, deRes);
        }

      } else {
        // No se recibió coResultado
        showAlert(divActualizar, 'danger', 'Error', 'No se recibió coResultado en la respuesta. Verifique el servidor.');
      }
    })
    .catch(err => {
      console.error(err);
      showAlert(divActualizar, 'danger', 'Error de conexión', err);
    });
  });


  // =======================================
  // C) CONSULTAR DNI
  // =======================================
  const frmConsultar = document.getElementById('frmConsultar');
  const divConsulta  = document.getElementById('resultadoConsulta');

  frmConsultar.addEventListener('submit', function(e) {
    e.preventDefault();
    divConsulta.innerHTML = ""; // Limpia alertas previas

    const formData = new FormData(frmConsultar);

    fetch("{{ route('reniec.consultar') }}", {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(json => {
      console.log("Consultar JSON:", json);

      if (json.error) {
        return showAlert(divConsulta, 'danger', 'Error', json.error);
      }

      // Revisamos si PIDE trae consultarResponse
      if (json.data && json.data.consultarResponse) {
        const retorno = json.data.consultarResponse.return;
        if (!retorno) {
          return showAlert(divConsulta, 'danger', 'Error', 'No se encontró "return" en la respuesta.');
        }

        const coResultado  = retorno.coResultado;
        const deResultado  = retorno.deResultado;
        const datosPersona = retorno.datosPersona;

        if (coResultado === "0000") {
          // Éxito
          let html = `
            <div class="alert alert-success">
              <h5>Consulta Exitosa</h5>
              <p><strong>Código de Resultado:</strong> ${coResultado}</p>
              <p><strong>Mensaje:</strong> ${deResultado}</p>
          `;

          if (datosPersona) {
            let apPrimer    = datosPersona.apPrimer || 'N/A';
            let apSegundo   = datosPersona.apSegundo || 'N/A';
            let prenombres  = datosPersona.prenombres || 'N/A';
            let direccion   = datosPersona.direccion || 'N/A';
            let estadoCivil = datosPersona.estadoCivil || 'N/A';
            let restriccion = datosPersona.restriccion || 'N/A';
            let ubigeo      = datosPersona.ubigeo || 'N/A';
            let fotoBase64  = datosPersona.foto || '';

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
                  <img src="data:image/jpeg;base64,${fotoBase64}" alt="Foto del DNI" style="max-width: 200px;">
                </div>
              `;
            }
            html += `</div>`; // cierra alert-success
          }
          divConsulta.innerHTML = html;

        } else {
          // coResultado != 0000 => error
          divConsulta.innerHTML = `
            <div class="alert alert-warning">
              <strong>Atención [${coResultado}]</strong>: ${deResultado}
            </div>`;
        }
      } else {
        showAlert(divConsulta, 'danger', 'Error', 'No se encontró "consultarResponse" en la respuesta.');
      }
    })
    .catch(error => {
      console.error(error);
      showAlert(divConsulta, 'danger', 'Error de conexión', error);
    });
  });


  // =======================================
  // D) Función para Mostrar Alertas (reutilizable)
  // =======================================
  function showAlert(container, alertType, strongText, normalText) {
    // Ej: alertType = 'success' | 'danger' | 'warning'
    container.innerHTML = `
      <div class="alert alert-${alertType}">
        <strong>${strongText}:</strong> ${normalText}
      </div>
    `;
  }

});
</script>
@endsection
