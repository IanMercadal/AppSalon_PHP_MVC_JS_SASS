<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-grafica">Reestable tu password escribiendo tu email a continuación</p>

<form class="formulario" action="/olvide" method="post">
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="text"
            id="email"
            name="email"
            placeholder="Tu Email"
        >
    </div>

    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Crear una</a>
</div>