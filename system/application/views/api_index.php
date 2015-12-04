<h2>Introducción</h2>
<p>
    La nueva API de GobiernoTransparenteChile busca ayudar a que la comunidad desarrolle
    programas y aplicaciones web usando la información disponible en GobiernoTransparenteChile.
</p>
<p>
    Cada servicio del estado tiene una ID unica. Tu puedes extraer datos asociados a un servicio
    mediante una llamada a http://www.gobiernotransparentechile.cl/api/ID. Por ejemplo, Presidencia
    de la Republica tiene el ID 1, asi que puedes obtener sus datos accediendo a
    <a href="http://www.gobiernotransparentechile.cl/api/1">http://www.gobiernotransparentechile.cl/api/1</a>
</p>
<code>
    {
    "id" : 1,
    "nombre" : "Presidencia de la Republica",
    "url" : "http://www.presidencia.cl/transparencia",
    "entidad_padre" : "Presidencia de la Republica",
    "fecha_actualizacion" : "2010-10-05"
    }
</code>
<p>
    Cada servicio tiene paginas de datos que pueden ser accedidas usando la estructura
    http://www.gobiernotransparentechile.cl/api/ID/PAGINA. Las páginas soportadas son:
</p>
<ul class="lista">
    <li>Marco Normativo: <a href="http://www.gobiernotransparentechile.cl/api/1/marco_normativo">http://www.gobiernotransparentechile.cl/api/1/marco_normativo</a></li>
    <li>Personal de Planta: <a href="http://www.gobiernotransparentechile.cl/api/1/per_planta">http://www.gobiernotransparentechile.cl/api/1/per_planta</a></li>
</ul>