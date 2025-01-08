@extends('layouts.app')

@section('content')

<div class="content-wrapper"><!-- AdminLTE pattern -->
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
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
        <div class="container-fluid">

            <!-- Notificaciones de éxito o error (si usas session para otras cosas) -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <!-- Formularios lado a lado (responsive) -->
            <div class="row" style="gap: 20px; align-items: stretch;">
                
                <!-- Formulario para ACTUALIZAR CREDENCIAL -->
                <div class="col-md-6"><!-- col-md-6 para 2 columnas en desktop -->
                    <div class="card" style="min-height: 300px;">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">Gestionar Credenciales</h3>
                        </div>
                        <div class="card-body">
                            <form id="frmActualizar" autocomplete="off">
                                @csrf
                                <div class="form-group mb-3 position-relative">
                                    <label for="credencialAnterior">Credencial Actual:</label>
                                    <div class="input-group">
                                        <input type="password" id="credencialAnterior" name="credencialAnterior" class="form-control" required minlength="8">
                                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="credencialAnterior" aria-label="Mostrar u ocultar credencial actual">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mb-3 position-relative">
                                    <label for="credencialNueva">Nueva Credencial:</label>
                                    <div class="input-group">
                                        <input type="password" id="credencialNueva" name="credencialNueva" class="form-control" required minlength="8">
                                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="credencialNueva" aria-label="Mostrar u ocultar nueva credencial">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nuDni">DNI (Usuario):</label>
                                    <input type="text" id="nuDni" name="nuDni" class="form-control" required pattern="\d{8}" title="El DNI debe tener 8 dígitos">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nuRuc">RUC de la Entidad:</label>
                                    <input type="text" id="nuRuc" name="nuRuc" class="form-control" required pattern="\d{11}" title="El RUC debe tener 11 dígitos">
                                </div>
                                <button type="submit" class="btn btn-primary mt-2" style="width: 100%;">Actualizar Credencial</button>
                            </form>
                            <!-- Aquí mostramos el resultado de actualizar -->
                            <div id="resultadoActualizar" class="mt-3"></div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulario para CONSULTAR DNI -->
                <div class="col-md-6">
                    <div class="card" style="min-height: 300px;">
                        <div class="card-header bg-success text-white">
                            <h3 class="card-title">Consulta de DNI</h3>
                        </div>
                        <div class="card-body">
                            <form id="frmConsultar" autocomplete="off">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="nuDniConsulta">DNI a Consultar:</label>
                                    <input type="text" id="nuDniConsulta" name="nuDniConsulta" class="form-control" required pattern="\d{8}" title="El DNI debe tener 8 dígitos">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nuDniUsuario">Tu DNI (Usuario):</label>
                                    <input type="text" id="nuDniUsuario" name="nuDniUsuario" class="form-control" required pattern="\d{8}" title="El DNI debe tener 8 dígitos">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="nuRucUsuario">RUC de la Entidad:</label>
                                    <input type="text" id="nuRucUsuario" name="nuRucUsuario" class="form-control" required pattern="\d{11}" title="El RUC debe tener 11 dígitos">
                                </div>
                                <div class="form-group mb-3 position-relative">
                                    <label for="password">Contraseña PIDE:</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control" required minlength="8">
                                        <button type="button" class="btn btn-outline-secondary toggle-password" data-target="password" aria-label="Mostrar u ocultar contraseña PIDE">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-2" style="width: 100%;">Consultar</button>
                            </form>
                            <!-- Aquí mostramos el resultado de consulta -->
                            <div id="resultadoConsulta" class="mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
</div><!-- /.content-wrapper -->


<!-- Scripts para manejar AJAX (fetch) y mostrar/ocultar contraseñas -->
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para mostrar alertas en contenedores específicos
    function mostrarAlerta(tipo, mensaje, contenedorId) {
        const contenedor = document.getElementById(contenedorId);
        contenedor.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>`;
    }

    // Función para alternar la visibilidad de las contraseñas
    function togglePasswordVisibility(button) {
        const targetId = button.getAttribute('data-target');
        const passwordInput = document.getElementById(targetId);
        const icon = button.querySelector('i');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Agregar event listeners a todos los botones toggle-password
    const toggleButtons = document.querySelectorAll('.toggle-password');
    toggleButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            togglePasswordVisibility(button);
        });
    });

    // =========================================
    // 1. ACTUALIZAR CREDENCIAL
    // =========================================
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
                // Error del servidor (excepción, etc.)
                mostrarAlerta('danger', `<strong>Error:</strong> ${json.error}`, 'resultadoActualizar');
                return;
            }

            // Estructura: { data: { coResultado, deResultado }, ... }
            if (json.data && json.data.coResultado) {
                const coRes = json.data.coResultado;
                const deRes = json.data.deResultado || 'Sin descripción';

                if (coRes === '0000') {
                    // éxito
                    mostrarAlerta('success', `<strong>¡Credencial actualizada con éxito!</strong><br>${deRes}`, 'resultadoActualizar');
                } else {
                    // Advertencia
                    mostrarAlerta('warning', `<strong>Atención:</strong> [${coRes}] ${deRes}`, 'resultadoActualizar');
                }
            } else {
                mostrarAlerta('danger', `<strong>No se encontró "coResultado" en la respuesta</strong>`, 'resultadoActualizar');
            }
        })
        .catch(err => {
            console.error(err);
            mostrarAlerta('danger', `<strong>Error de conexión:</strong> ${err}`, 'resultadoActualizar');
        });
    });


    // =========================================
    // 2. CONSULTAR DNI
    // =========================================
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
            mostrarAlerta('danger', `<strong>Error de conexión:</strong> ${error}`, 'resultadoConsulta');
        });
    });

    function renderConsulta(json) {
        if (json.error) {
            mostrarAlerta('danger', `<strong>Error:</strong> ${json.error}`, 'resultadoConsulta');
            return;
        }

        if (json.data && json.data.consultarResponse) {
            const retorno = json.data.consultarResponse.return;
            if (!retorno) {
                mostrarAlerta('danger', `No se encontró "return" en la respuesta.`, 'resultadoConsulta');
                return;
            }

            const coResultado  = retorno.coResultado;
            const deResultado  = retorno.deResultado;
            const datosPersona = retorno.datosPersona;

            if (coResultado === "0000") {
                // éxito
                let html = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h5>Consulta Exitosa</h5>
                        <p><strong>Código de Resultado:</strong> ${coResultado}</p>
                        <p><strong>Mensaje:</strong> ${deResultado}</p>
                        <ul>
                            <li><strong>Primer Apellido:</strong> ${datosPersona.apPrimer || 'N/A'}</li>
                            <li><strong>Segundo Apellido:</strong> ${datosPersona.apSegundo || 'N/A'}</li>
                            <li><strong>Nombres:</strong> ${datosPersona.prenombres || 'N/A'}</li>
                            <li><strong>Dirección:</strong> ${datosPersona.direccion || 'N/A'}</li>
                            <li><strong>Estado Civil:</strong> ${datosPersona.estadoCivil || 'N/A'}</li>
                            <li><strong>Ubigeo:</strong> ${datosPersona.ubigeo || 'N/A'}</li>
                            <li><strong>Restricción:</strong> ${datosPersona.restriccion || 'N/A'}</li>
                        </ul>
                `;

                if (datosPersona.fotoBase64) {
                    html += `
                        <div>
                            <strong>Foto:</strong><br>
                            <img src="data:image/jpeg;base64,${datosPersona.fotoBase64}" alt="Foto del DNI" style="max-width: 200px;">
                        </div>
                    `;
                }
                html += `
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>`;
                
                divConsulta.innerHTML = html;

            } else {
                // coResultado != 0000 => error
                mostrarAlerta('warning', `<strong>Atención:</strong> [${coResultado}] ${deResultado}`, 'resultadoConsulta');
            }
        } else {
            mostrarAlerta('danger', `No se encontró "consultarResponse" en la respuesta.`, 'resultadoConsulta');
        }
    }
});
</script>
@endsection


{{-- @extends('layouts.app')

@section('content')

<div class="content-wrapper"><!-- AdminLTE pattern -->
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
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
    <div class="container-fluid">

      <!-- Notificaciones de éxito o error (si usas session para otras cosas) -->
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
        
        <!-- Formulario para ACTUALIZAR CREDENCIAL -->
        <div class="col-md-6"><!-- col-md-6 para 2 columnas en desktop -->
          <div class="card" style="min-height: 300px;">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">Gestionar Credenciales</h3>
            </div>
            <div class="card-body">
              <form id="frmActualizar" onsubmit="return false;">
                @csrf
                <div class="form-group">
                  <label for="credencialAnterior">Credencial Actual:</label>
                  <input type="password" id="credencialAnterior" name="credencialAnterior" class="form-control" required>
                </div>
                <div class="form-group">
                  <label for="credencialNueva">Nueva Credencial:</label>
                  <input type="password" id="credencialNueva" name="credencialNueva" class="form-control" required minlength="8">
                </div>
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
              <!-- Aquí mostramos el resultado de actualizar -->
              <div id="resultadoActualizar" class="mt-3"></div>
            </div>
          </div>
        </div>
        
        <!-- Formulario para CONSULTAR DNI -->
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
              <!-- Aquí mostramos el resultado de consulta -->
              <div id="resultadoConsulta" class="mt-3"></div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </section>
</div><!-- /.content-wrapper -->


<!-- Scripts para manejar AJAX (fetch) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // =========================================
  // 1. ACTUALIZAR CREDENCIAL
  // =========================================
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
        // Error del servidor (excepción, etc.)
        divActualizar.innerHTML = `
          <div class="alert alert-danger">
            <strong>Error:</strong> ${json.error}
          </div>`;
        return;
      }

      // Estructura: { data: { coResultado, deResultado }, ... }
      if (json.data && json.data.coResultado) {
        const coRes = json.data.coResultado;
        const deRes = json.data.deResultado || 'Sin descripción';

        if (coRes === '0000') {
          // éxito
          divActualizar.innerHTML = `
            <div class="alert alert-success">
              <strong>¡Credencial actualizada con éxito!</strong><br>
              ${deRes}
            </div>`;
        } else {
          // Advertencia
          divActualizar.innerHTML = `
            <div class="alert alert-warning">
              <strong>Atención:</strong> [${coRes}] ${deRes}
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


  // =========================================
  // 2. CONSULTAR DNI
  // =========================================
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

    if (json.data && json.data.consultarResponse) {
      const retorno = json.data.consultarResponse.return;
      if (!retorno) {
        divConsulta.innerHTML = `<div class="alert alert-danger">No se encontró "return" en la respuesta.</div>`;
        return;
      }

      const coResultado  = retorno.coResultado;
      const deResultado  = retorno.deResultado;
      const datosPersona = retorno.datosPersona;

      if (coResultado === "0000") {
        // éxito
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

@endsection --}}
