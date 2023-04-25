<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dompdf\Dompdf;

class PdfController extends Controller
{
    public function formulario()
    {
        // Muestra el formulario para ingresar el texto y el título
        return '<form method="post" action="/api/generar-pdf">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Escribe aquí el título"><br><br>
                    <label for="texto">Texto:</label>
                    <textarea id="texto" name="texto" placeholder="Escribe aquí el texto"></textarea><br><br>
                    <button type="submit">Generar PDF</button>
                </form>';
    }

    public function generarPdf(Request $request)
    {
        // Obtiene el texto ingresado en el formulario
        $texto = $request->input('texto');
        $titulo = $request->input('titulo');
        
        // Crea una nueva instancia de Dompdf
        $dompdf = new Dompdf();
        
        // Genera el contenido HTML que quieres convertir a PDF
        $html = '<h1>' . $titulo . '</h1><p>' . $texto . '</p>';
        
        // Convierte el contenido HTML a PDF
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        // Descarga el PDF en el navegador
        return $dompdf->stream($titulo . '.pdf');
    }
}