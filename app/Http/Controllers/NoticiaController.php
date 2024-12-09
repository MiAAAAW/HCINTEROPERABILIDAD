<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    // Mostrar el formulario para crear una noticia
    public function create()
    {
        return view('admin.noticias.create');
    }

    // Guardar una noticia en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'enlace1' => 'nullable|url',
            'enlace2' => 'nullable|url',
            'fecha_publicacion' => 'required|date',
        ]);

        // Crear la noticia
        Noticia::create([
            'titulo' => $request->input('titulo'),
            'contenido' => $request->input('contenido'),
            'enlace1' => $request->input('enlace1'),
            'enlace2' => $request->input('enlace2'),
            'fecha_publicacion' => $request->input('fecha_publicacion'),
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia creada correctamente');
    }

    // Mostrar todas las noticias
    public function index()
    {
        $noticias = Noticia::orderBy('fecha_publicacion', 'desc')->get();
        return view('admin.noticias.index', compact('noticias'));
    }

    // Eliminar una noticia
    public function destroy($id)
    {
        $noticia = Noticia::findOrFail($id);
        $noticia->delete();
        return redirect()->back()->with('success', 'Noticia eliminada correctamente');
    }


    //edita la noticia
    public function edit($id)
    {
        //dd($id);
        $noticia = Noticia::findOrFail($id);
        return view('admin.noticias.edit', compact('noticia'));
    }

    // Método para actualizar una noticia
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'enlace1' => 'nullable|url',
            'enlace2' => 'nullable|url',
            'fecha_publicacion' => 'required|date',
        ]);

        // Actualizar la noticia
        $noticia = Noticia::findOrFail($id);
        $noticia->update($request->all());

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia actualizada correctamente');
    }

}
