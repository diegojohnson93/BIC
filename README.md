# BIC · BIM Integration Consulting — sitio web

Sitio estático (HTML, CSS y JavaScript) con formulario de contacto en PHP. Se publica en Hostinger directamente desde este repositorio y se edita pidiéndole los cambios a Claude.

Páginas: Inicio, Servicios, Jaca·Box, Equipo, Investigación y Contacto.

---

## 1. Cómo pedir un cambio (equipo de BIC)

1. Abre Claude Code (en la web o en la app) con este repositorio conectado.
2. Pide el cambio en palabras normales. Por ejemplo:
   - "Cambia el correo de contacto a contacto@bimconsulting.cl en todas las páginas."
   - "Agrega esta tesis: *Título…*, de Nombre Apellido, 2025."
   - "Reemplaza la foto de Franco por esta" (adjunta la foto).
3. Claude hace el cambio y abre un **pull request** (una propuesta de cambio).
4. Diego lo revisa y lo aprueba. Al aprobarlo, el sitio se actualiza solo en 1 a 2 minutos.

Las reglas que sigue el agente están en `CLAUDE.md`: qué puede tocar, qué no, cómo manejar fotos y textos.

---

## 2. Publicación en Hostinger (una sola vez)

1. **Plan:** un plan de *Web Hosting* (no el constructor de sitios, porque no permite conectar Git). Un mismo plan Premium o superior admite los tres sitios del grupo.
2. **Agregar el sitio:** en hPanel → *Websites* → *Add website* → elige el dominio de BIC.
3. **Conectar GitHub:** en el sitio → *Dashboard* → *Advanced* → *Git* → *Continue with GitHub*. Autoriza el acceso a este repositorio, elige la rama `main` y deja la carpeta de destino en `public_html`.
4. **Publicación automática:** verifica que *Auto deployment* esté activo. Cada cambio aprobado en `main` se publica solo.
5. **HTTPS:** en hPanel → *Security* → *SSL*, activa el certificado gratuito y la opción *Force HTTPS*.
6. **Dominio .cl:** en NIC Chile, apunta los servidores DNS del dominio a los de Hostinger (aparecen en hPanel → *Domains*).

## 3. Correo del formulario

El formulario de todas las páginas envía a `enviar.php`, que manda la consulta por correo.

1. En hPanel → *Emails*, crea dos casillas del dominio de BIC:
   - una para **recibir** las consultas (ej. `contacto@…`);
   - una para **enviar** (ej. `no-reply@…`). Usar una casilla del mismo dominio evita que los mensajes caigan en spam.
2. Edita las dos primeras líneas de configuración de `enviar.php`:
   ```php
   $DESTINO   = 'contacto@bimconsulting.cl';
   $REMITENTE = 'no-reply@bimconsulting.cl';
   ```
3. Envía una consulta de prueba desde el sitio publicado y revisa la bandeja de entrada y la de spam.

El formulario incluye protección antispam: un campo oculto que solo llenan los robots y un tiempo mínimo de llenado.

## 4. Proteger la rama `main` (recomendado)

Así nadie, ni el agente, puede publicar sin aprobación:

GitHub → este repositorio → *Settings* → *Branches* (o *Rules → Rulesets*) → regla para `main` → activar **Require a pull request before merging** y **Require approvals (1)**.

## 5. Vista previa

Mientras no esté en Hostinger, el sitio se puede ver en GitHub Pages (*Settings → Pages → Deploy from a branch → main / root*). En esa vista el formulario no envía correos, porque GitHub Pages no ejecuta PHP.

## Pendiente de contenido

Correo y LinkedIn de BIC; foto, reseña y especialidades de Franco Asenjo; tesis guiadas; dominios definitivos de los sitios del grupo.
