<?php
    require 'includes/functions.php';
    includeTemplate('header')
?>

<div class="container">
    <h1>Sign Up</h1>
    
    <div class="signup-div">

        <ul class="setup-panel">
            <li class="active">
                <a href="#step-1">
                    <i class="fa fa-eye"></i>
                    I'm looking for...
                </a>
            </li>
            
            <li class="disabled">
                <a href="#step-2">
                    <i class="fa fa-compact-disc"></i>
                    I am...
                </a>
            </li>

            <li class="disabled">
                <a href="#step-3">
                    <i class="fa fa-user-pen"></i>
                    Account data
                </a>
            </li>

        </ul>

        <!--Contenido primer formulario: Necesidad del usuario-->
        <div class="setup-content" id="step-1">
            <div class="signup-content">
                <h1>I'm looking for:</h1>

                <form method="POST" action="">
                    <div class="campos">
                        <input type="radio" id="musical-content" name="needs">
                        <label for="musical-content">
                            Musical Content for my project
                        </label>
                    </div>

                    <p>OR</p>

                    <div class="campos">
                        <input type="radio" id="my-music" name="needs">
                        <label for="my-music">
                           I want to upload my music
                        </label>
                    </div>

                    <div class="campos">
                        <input type="radio" id="hiring" name="needs">
                        <label for="hiring">                            
                            Hire artist for oundtrack
                        </label>
                    </div>
                </form>

                <button id="activate-step-2" class="botones">Continuar</button>

            </div>
        </div>

        <!--Contenido segundo formulario: tipo de artista-->
        <div class="setup-content" id="step-2">
            <div class="signup-content">
                <h1>I am:</h1>

                <form method="POST" action="">
                    <div class="campos">
                        <input type="radio" id="artist" name="needs">
                        <label for="artist">
                            Independent Artist
                        </label>
                    </div>

                    <p>OR</p>

                    <div class="campos">
                        <input type="radio" id="label" name="needs">
                        <label for="label">
                            Label or Music Editor
                        </label>
                    </div>

                    <div class="campos">
                        <input type="radio" id="producer" name="needs">
                        <label for="producer">                            
                            Music Producer
                        </label>
                    </div>
                </form>

                <button id="activate-step-3" name="singlebutton" class="botones">ACTIVE STEP 3</button>

            </div>
        </div>

        <!--Contenido tercer formulario: Datos de usuario-->
        <div class="setup-content" id="step-3">
            <div class="signup-content">

                <h1>Create your account</h1>

                <form method="POST" action="">

                    <div class="campos">
                        <x-jet-label for="name" value="{{ __('Name') }}" />
                        <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    </div>

                    <div class="campos">
                        <x-jet-label for="email" value="{{ __('Email') }}" />
                        <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>

                    <div class="campos">
                        <x-jet-label for="password" value="{{ __('Password') }}" />
                        <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    </div>

                    <div class="campos">
                        <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    

                    <div class="forgot">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-jet-button class="botones">
                            {{ __('Register') }}
                        </x-jet-button>
                    </div>
                </form>


            </div>
        </div>

    </div>
</div>




<?php
    includeTemplate('footer');
?>