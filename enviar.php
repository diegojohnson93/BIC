<?php
/**
 * Formulario de contacto de BIC: recibe la consulta y la envía por correo.
 *
 * CONFIGURACIÓN (cambiar al publicar):
 * - $DESTINO:   correo donde llegan las consultas.
 * - $REMITENTE: correo del mismo dominio del sitio (ej. no-reply@bimconsulting.cl).
 *               Debe existir en Hostinger (Correos) para que los mensajes no caigan en spam.
 */
$DESTINO   = 'contacto@bimconsulting.cl';
$REMITENTE = 'no-reply@bimconsulting.cl';
$NOMBRE_SITIO = 'BIC · BIM Integration Consulting';

date_default_timezone_set('America/Santiago');
header('X-Content-Type-Options: nosniff');

function responder($ok, $mensaje, $codigo = 200)
{
    $quiereJson = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
    if ($quiereJson) {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array('ok' => $ok, 'mensaje' => $mensaje), JSON_UNESCAPED_UNICODE);
    } else {
        header('Location: contacto.html?enviado=' . ($ok ? '1' : '0'), true, 303);
    }
    exit;
}

function campo($nombre, $max = 200)
{
    $v = isset($_POST[$nombre]) ? trim((string) $_POST[$nombre]) : '';
    $v = str_replace(array("\r", "\0"), '', $v);
    if (function_exists('mb_substr')) {
        return mb_substr($v, 0, $max, 'UTF-8');
    }
    return substr($v, 0, $max);
}

function linea($v)
{
    // Para campos de una línea: sin saltos (evita inyección en cabeceras).
    return trim(preg_replace('/[\r\n]+/', ' ', $v));
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contacto.html', true, 303);
    exit;
}

// Antispam: campo trampa oculto y tiempo mínimo de llenado (3 s).
if (campo('sitio_web') !== '') {
    responder(true, 'Gracias. Recibimos su consulta.');
}
$t = (int) campo('_t', 20);
if ($t > 0 && (time() * 1000 - $t) < 3000) {
    responder(true, 'Gracias. Recibimos su consulta.');
}

$nombre    = linea(campo('nombre', 120));
$empresa   = linea(campo('empresa', 120));
$cargo     = linea(campo('cargo', 120));
$correo    = linea(campo('correo', 160));
$telefono  = linea(campo('telefono', 40));
$ubicacion = linea(campo('ubicacion', 160));
$servicio  = linea(campo('servicio', 120));
$etapa     = linea(campo('etapa', 60));
$tipo      = linea(campo('tipo', 60));
$mensaje   = campo('mensaje', 4000);
$pagina    = linea(campo('pagina', 160));

if ($nombre === '' || $correo === '' || $telefono === '') {
    responder(false, 'Faltan campos obligatorios: nombre, correo y teléfono.', 422);
}
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    responder(false, 'El correo ingresado no es válido.', 422);
}

$asunto = 'Nueva consulta desde el sitio web' . ($servicio !== '' ? ' — ' . $servicio : '');
$cuerpo = "Nueva consulta recibida en el sitio de $NOMBRE_SITIO\n\n"
    . "Nombre: $nombre\n"
    . "Empresa: $empresa\n"
    . "Cargo: $cargo\n"
    . "Correo: $correo\n"
    . "Teléfono: $telefono\n"
    . "Ubicación del proyecto: $ubicacion\n"
    . "Servicio: $servicio\n"
    . "Etapa del proyecto: $etapa\n"
    . "Tipo de proyecto: $tipo\n\n"
    . "Mensaje:\n$mensaje\n\n"
    . "—\nEnviado desde: $pagina\n"
    . 'Fecha: ' . date('d-m-Y H:i') . "\n";

$asuntoCod = function_exists('mb_encode_mimeheader')
    ? mb_encode_mimeheader($asunto, 'UTF-8', 'B', "\r\n")
    : '=?UTF-8?B?' . base64_encode($asunto) . '?=';
$nombreCod = '=?UTF-8?B?' . base64_encode($NOMBRE_SITIO) . '?=';

$cabeceras = array(
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
    'From: ' . $nombreCod . ' <' . $REMITENTE . '>',
    'Reply-To: ' . $correo,
);

$enviado = @mail($DESTINO, $asuntoCod, $cuerpo, implode("\r\n", $cabeceras), '-f' . $REMITENTE);

if ($enviado) {
    responder(true, 'Gracias. Recibimos su consulta y le responderemos dentro de 48 horas.');
}
responder(false, 'No pudimos enviar su consulta. Escríbanos por WhatsApp o llámenos al +56 9 4070 4986.', 500);
