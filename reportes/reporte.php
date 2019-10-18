<?php

    require_once __DIR__ . '/../vendor/autoload.php';
    header('Content-Type: application/pdf');

    // Instancia del PDF.
    $mpdf = new \Mpdf\Mpdf();

    // Contenido.
    $contenido = 'Este sería el contenido';


    // Escribir PDF.
    $mpdf->WriteHTML($contenido);

    // Salida al navegador.
    
    $mpdf->Output();
?>