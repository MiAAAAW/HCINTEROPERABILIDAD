@extends('layouts.app')

@section('content')
<div class="content-wrapper"><!-- Ajusta el espaciado general -->

  <!-- Content Header -->
  <div class="content-header">
    <div class="container">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1 class="m-0">Consulta y Actualización de Credenciales (RENIEC - PIDE)</h1>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <section class="content">
    <div class="container">

      <!-- Notificaciones -->
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

      <!-- Formularios lado a lado -->
      <div class="row" style="gap: 20px; align-items: stretch;">

        <!-- Formulario ACTUALIZAR -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                 onclick="toggleCollapse('collapseActualizar', 'iconActualizar')"
                 style="cursor: pointer;">
              <h3 class="card-title">Gestionar Credenciales</h3>
              <i id="iconActualizar" class="fas fa-chevron-up toggle-icon"></i>
            </div>
            <div id="collapseActualizar" class="collapse show">
              <div class="card-body">
                <form id="frmActualizar" onsubmit="return false;">
                  @csrf
                  <div class="form-group" style="position: relative;">
                    <label for="credencialAnterior">Credencial Actual:</label>
                    <input type="password" id="credencialAnterior" name="credencialAnterior" class="form-control" required>
                    <i class="fas fa-eye" id="toggleCredAnterior" style="position: absolute; top: 35px; right: 15px; cursor: pointer;"></i>
                  </div>
                  <div class="form-group" style="position: relative;">
                    <label for="credencialNueva">Nueva Credencial:</label>
                    <input type="password" id="credencialNueva" name="credencialNueva" class="form-control" required minlength="8">
                    <i class="fas fa-eye" id="toggleCredNueva" style="position: absolute; top: 35px; right: 15px; cursor: pointer;"></i>
                  </div>
                  <div class="form-group">
                    <label for="nuDni">DNI (Usuario):</label>
                    <input type="text" id="nuDni" name="nuDni" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label for="nuRuc">RUC de la Entidad:</label>
                    <input type="text" id="nuRuc" name="nuRuc" class="form-control" required value="20181438364">
                  </div>
                  <button type="submit" class="btn btn-primary mt-2 w-100">Actualizar Credencial</button>
                </form>
                <div id="resultadoActualizar" class="mt-3"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Formulario CONSULTAR -->
        <div class="col-md-6">
          <div class="card">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center"
                 onclick="toggleCollapse('collapseConsultar', 'iconConsultar')"
                 style="cursor: pointer;">
              <h3 class="card-title">Consulta de DNI</h3>
              <i id="iconConsultar" class="fas fa-chevron-up toggle-icon"></i>
            </div>
            <div id="collapseConsultar" class="collapse show">
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
                    <input type="text" id="nuRucUsuario" name="nuRucUsuario" class="form-control" required value="20181438364">
                  </div>
                  <div class="form-group" style="position: relative;">
                    <label for="password">Contraseña PIDE:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <i class="fas fa-eye" id="togglePasswordPIDE" style="position: absolute; top: 35px; right: 15px; cursor: pointer;"></i>
                  </div>
                  <button type="submit" class="btn btn-success mt-2 w-100">Consultar</button>
                </form>
                <div id="resultadoConsulta" class="mt-3"></div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</div>


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
            const isPassword = (inputField.type === 'password');
            inputField.type = isPassword ? 'text' : 'password';
            // Cambiar ícono (fa-eye <-> fa-eye-slash)
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
        divActualizar.innerHTML = "";

        const formData = new FormData(frmActualizar);

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

        if (json.data && json.data.coResultado) {
            const coRes = json.data.coResultado;
            const deRes = json.data.deResultado || 'Sin descripción';

            if (coRes === '0000') {
            // Éxito
            divActualizar.innerHTML = `
                <div class="alert alert-success">
                <strong>¡Credencial actualizada con éxito!</strong><br>
                ${deRes}
                </div>`;
            } else {
            // Error
            divActualizar.innerHTML = `
                <div class="alert alert-danger">
                <strong>Error [${coRes}]:</strong> ${deRes}
                </div>`;
            }
        } else {
            divActualizar.innerHTML = `
            <div class="alert alert-danger">
                <strong>Error:</strong> No se recibió "coResultado" en la respuesta.
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


    // =======================================
    // C) CONSULTAR DNI
    // =======================================
    const frmConsultar = document.getElementById('frmConsultar');
    const divConsulta  = document.getElementById('resultadoConsulta');

    frmConsultar.addEventListener('submit', function(e) {
        e.preventDefault();
        divConsulta.innerHTML = "";

        const formData = new FormData(frmConsultar);

        fetch("{{ route('reniec.consultar') }}", {
        method: 'POST',
        body: formData
        })
        .then(response => response.json())
        .then(json => {
        console.log("Consultar JSON:", json);

        if (json.error) {
            divConsulta.innerHTML = `
            <div class="alert alert-danger">
                <strong>Error:</strong> ${json.error}
            </div>`;
            return;
        }

        // Revisamos si PIDE trae consultarResponse
        if (json.data && json.data.consultarResponse) {
            const retorno = json.data.consultarResponse.return;
            if (!retorno) {
            divConsulta.innerHTML = `
                <div class="alert alert-danger">
                No se encontró "return" en la respuesta.
                </div>`;
            return;
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
                <strong>Atención [${coResultado}]:</strong> ${deResultado}
                </div>`;
            }
        } else {
            divConsulta.innerHTML = `
            <div class="alert alert-danger">
                No se encontró "consultarResponse" en la respuesta.
            </div>`;
        }
        })
        .catch(error => {
        console.error(error);
        divConsulta.innerHTML = `
            <div class="alert alert-danger">
            <strong>Error de conexión:</strong> ${error}
            </div>`;
        });
    });

        // =======================================
    // D) COLAPSAR Y EXPANDIR CARDS
    // =======================================
    window.toggleCollapse = function(collapseId, iconId) {
      const collapse = document.getElementById(collapseId);
      const icon = document.getElementById(iconId);

      if (collapse.classList.contains('show')) {
        collapse.classList.remove('show');
        icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
      } else {
        collapse.classList.add('show');
        icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
      }
    };


    });
    </script>
@endsection

