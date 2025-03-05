<?php
    require 'includes/functions.php';
    includeTemplate('header')
?>

<div class="container">
    <h1>Cuéntanos más sobre tu proyecto</h1>

    <div class="recuadro">
        <form method="POST" action="">

            <a href="/tipolicencia.php">
                <div class="songs">
                    <div class="firma-btn">
                        <p>Tipo de licencia</p>
                        <img src="build/img/rightarrow.svg"/>
                    </div>   
                </div>
            </a>
            
            <div class="campos">
                <label for="name" value="" >Nombre de tu proyecto </label>
                <input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="campos">
                <label for="tiempo" value="" >Duración tu proyecto </label>
                <input id="" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="" />
            </div>

            <div class="campos">
                <label for="tiempo" value="" >Cuéntanos más sobre tu proyecto </label>
                <textarea id="" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete=""></textarea>
            </div>

            <div class="campos">
                <label for="tiempo" value="" >En qué momento exacto usarás esta canción</label>
                <input id="" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="" />
            </div>


            <div class="bloque-btn">
                <button class="botones">
                    Agregar Uso
                </button>
            </div>

            <div class="songs">
                <div class="firma-btn">
                    <p>Firmar contrato de licencia</p>
                    <img src="build/img/download.svg"/>
                </div>   
            </div>

            <div class="bloque-btn">
                <a href="/cart.php" class="botones">
                    Guardar
                </a>
            </div>

        </form>
    </div>
</div>

<?php
    includeTemplate('footer');
?>