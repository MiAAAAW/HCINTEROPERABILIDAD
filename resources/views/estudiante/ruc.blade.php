@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Consulta de RUC - SUNAT</h2>
    <form id="form-consulta-ruc" method="POST" action="{{ route('sunat.todos-los-datos') }}">
        @csrf
        <div class="mb-3">
            <label for="numruc" class="form-label">Número de RUC</label>
            <input type="text" class="form-control" id="numruc" name="numruc" required placeholder="Ingrese el número de RUC">
        </div>
        <div class="mb-3">
            <label for="tipo-consulta" class="form-label">Tipo de Consulta</label>
            <select class="form-select" id="tipo-consulta" name="tipo_consulta">
                <option value="soap" selected>SOAP</option>
                <option value="rest">REST</option>
                <option value="todos">Ambos</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>

    <div id="resultados" class="mt-5" style="display: none;">
        <h4>Resultados</h4>
        <pre id="output" class="bg-light p-3 border"></pre>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('form-consulta-ruc').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const tipoConsulta = formData.get('tipo_consulta');
        let url = '';

        // Selección de ruta según el tipo de consulta
        if (tipoConsulta === 'soap') {
            url = "{{ route('sunat.datos-principales') }}";
        } else if (tipoConsulta === 'rest') {
            url = "{{ route('sunat.datos-rest') }}";
        } else {
            url = "{{ route('sunat.todos-los-datos') }}";
        }

        // Enviar solicitud con Fetch API
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('resultados').style.display = 'block';
            document.getElementById('output').textContent = JSON.stringify(data, null, 2);
        })
        .catch(error => {
            document.getElementById('resultados').style.display = 'block';
            document.getElementById('output').textContent = 'Error: ' + error.message;
        });
    });
</script>
@endsection
