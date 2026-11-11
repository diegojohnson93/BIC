# Instrucciones para el agente: sitio web de BIC

Este repositorio es el sitio web de **BIC · BIM Integration Consulting**: empresa chilena de ingeniería digital (BIM), parte del mismo grupo que JAS Peritajes y JAS Consultores. Sus directores son Jorge Acevedo y Franco Asenjo.

Quien te escribe es parte del equipo de BIC (o Diego, que diseñó y mantiene el sitio). Normalmente te pedirá **cambios pequeños de contenido**: textos, fotos, datos de contacto, tesis, etc. Tu trabajo es hacer exactamente ese cambio, sin alterar el diseño, y dejarlo listo para revisión.

## Cómo trabajar (obligatorio)

1. **Nunca publiques directo en `main`.** Crea una rama nueva (`cambio/descripcion-corta`), haz el cambio ahí y abre un **pull request** en español.
   Lo que entra a `main` se publica solo en el sitio real (Hostinger), por eso Diego revisa y aprueba cada pull request antes.
2. En el pull request explica en lenguaje simple: qué cambiaste, en qué páginas y por qué. Si cambiaste fotos, nómbralas.
3. **No inventes contenido.** Nada de cifras, clientes, proyectos, títulos, nombres ni testimonios que la persona no te haya dado. Si falta información, pregunta antes de escribir.
4. Escribe en **español de Chile**, tratando al visitante de **usted**, con frases claras y sobrias. Mantén el largo parecido al texto que reemplazas para no desarmar el diseño.
5. Si el pedido es ambiguo (por ejemplo, "cambia la foto de arriba"), pregunta en qué página y sección antes de editar.
6. Si piden algo que cambia el diseño, las animaciones, la estructura o agrega secciones nuevas, explica que eso lo debe aprobar Diego y pregunta si igual quieren que lo propongas en un pull request.

## Estructura del sitio

| Archivo | Página | Contenido principal |
|---|---|---|
| `index.html` | Inicio | Portada con anillos 3D, pilares, "Por qué elegirnos", servicios con la torre BIM animada, ciclo de vida, directores, grupo JAS, contacto |
| `servicios.html` | Servicios | Los 5 servicios con beneficios, entregables y foto |
| `jacabox.html` | Jaca·Box | Plataforma JACA·BOX (comercialización exclusiva de BIC en Chile) |
| `equipo.html` | Equipo | Perfiles de Jorge Acevedo y Franco Asenjo |
| `investigacion.html` | Investigación | Artículo en MDPI, tesis guiadas, contadores de trayectoria |
| `contacto.html` | Contacto | Solo el formulario |
| `enviar.php` | — | Recibe el formulario y lo envía por correo |
| `assets/img/` | — | Fotos del sitio |
| `assets/css/`, `assets/js/` | — | Diseño y animaciones. **No tocar** salvo pedido explícito aprobado por Diego |

Los textos están directamente en el HTML de cada página: busca el texto actual y reemplázalo.

## Lo que se repite en todas las páginas

Si cambias algo de esta lista, cámbialo en **las 6 páginas** (`index`, `servicios`, `jacabox`, `equipo`, `investigacion`, `contacto`):

- **Menú de escritorio**: dentro de `<header>`, los enlaces `class="navl"`.
- **Menú del celular**: el bloque `<div id="nv-ov" class="nv-ov">`, enlaces `class="nv-l"`. Debe tener las mismas secciones que el menú de escritorio.
- **Bloque de contacto** (dentro de `<section id="contacto">`): teléfono, correo, WhatsApp y LinkedIn.
- **Formulario**: mismos campos y opciones del selector "Servicio" en todas las páginas.
- **Pie de página** (`<footer>`).

Datos de contacto actuales:
- Teléfono y WhatsApp: `+56 9 4070 4986` (enlaces `tel:+56940704986` y `https://wa.me/56940704986`).
- Correo: pendiente, hoy dice `[contacto@bimconsulting.cl]`.
- LinkedIn: pendiente, hoy el enlace va a `#contacto`.

Si cambia el correo de destino de las consultas, actualiza también `$DESTINO` en `enviar.php` (y menciónalo en el pull request).

## Fotos

- Guárdalas en `assets/img/` con nombre en minúsculas y guiones, sin tildes ni espacios (ej. `franco-asenjo.jpg`).
- Formato JPG, lado mayor de 1600 px como máximo y menos de 300 KB. Si tienes Python con Pillow disponible, optimiza así:
  `python3 -c "from PIL import Image; im=Image.open('ORIGEN').convert('RGB'); im.thumbnail((1600,1600)); im.save('assets/img/NOMBRE.jpg', quality=82, optimize=True)"`
- Al reemplazar una foto, actualiza también su texto `alt` con una descripción breve en español.
- Las fotos con `class="pt"` se ven en blanco y negro y pasan a color con el mouse: es intencional, no lo cambies.
- Para reemplazar una foto, puedes sobrescribir el archivo con el mismo nombre o cambiar el `src`. Borra del repositorio las fotos que queden sin uso.

## Recetas frecuentes

- **Agregar una tesis** (`investigacion.html`, sección `id="tesis"`): copia una fila `<div class="trow rv">…</div>`, ajusta el número (`T-06 /`), el título en `<h3>` y la línea `Autor · Universidad · Año`. Elimina las filas de ejemplo que aún digan `[Título de la tesis]`.
- **Foto de Franco Asenjo**: hoy hay un recuadro con la "B" del logo (`class="ph-pend"`) en `index.html` (sección directores) y en `equipo.html`. Reemplázalo por la foto con el mismo marcado que usa la foto de Jorge Acevedo en esa misma sección.
- **Reseña o especialidades de Franco** (`equipo.html`): reemplaza los textos entre corchetes `[ ]`.
- **Cambiar un servicio**: los 5 servicios aparecen en `index.html` (animación de la torre, un bloque `class="tw-b"` por servicio) y en `servicios.html` (bloques `class="srow"`). Mantén siempre **5 servicios**: la animación de la torre tiene 5 etapas. Si cambia el nombre de un servicio, actualiza también la opción del selector "Servicio" en el formulario de las 6 páginas.
- **Enlaces al grupo** (`index.html`, sección "Grupo de ingeniería en construcción"): hoy apuntan a las versiones de prueba en GitHub Pages. Cuando existan los dominios definitivos de JAS Peritajes y JAS Consultores, reemplázalos.

## Identidad visual (no cambiar)

- Colores: grafito `#1C1D1F`, turquesa `#62BFB4`, blanco `#F5F6F5`, texto secundario `#4C4F53`.
- Tipografías: Inter Tight (títulos y textos), JetBrains Mono (etiquetas en mayúsculas).
- Logo BIM: un SVG dentro del HTML. No lo reemplaces por imágenes.

## Antes de abrir el pull request

- Revisa que no quedaron etiquetas HTML sin cerrar ni texto duplicado.
- Si puedes, abre la página en un navegador (o con `python3 -m http.server`) y mírala en ancho de escritorio y de celular.
- Busca restos: `grep -n "\[" *.html` muestra los textos pendientes entre corchetes. No los borres si nadie te dio el dato.
- Confirma que tocaste solo lo pedido: revisa `git diff`.

## Pendientes de contenido conocidos

- Correo y LinkedIn de BIC.
- Foto, reseña y especialidades de Franco Asenjo.
- Tesis guiadas (título, autor, año).
- Dominios definitivos de los sitios del grupo.
