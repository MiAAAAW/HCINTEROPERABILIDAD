<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\returnSelf;

class ImageController extends Controller
{

    public function showGallery(){
        $images = Storage::files('storage/public/images');
        return view('admin.flayer.add', compact('images'));
    }

    public function uploadImage(Request $request)
    {
        // Validar que el archivo subido sea una imagen
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generar un nombre único para la imagen
        $imageName = time() . '.' . $request->image->extension();

        // Guardar la imagen en la carpeta 'public/images'
        $request->image->storeAs('public/images', $imageName);
        //$request->image->move(public_path('assets/imgs'), $imageName);

        // Redirigir de vuelta a la galería con un mensaje de éxito
        return redirect()->route('admin.flayer')->with('success', 'Imagen subida con éxito.');
    }

}
