<div class="container">
    <a href="/filmtono/contracts" class="btn-back">
    <i class="fa-solid fa-arrow-left"></i>
        {%contracts_back-btn%}
    </a>
    <h1><?php echo ($type == 'music') ? '{%contract_music%}' : '{%contract_artistic%}';?></h1>

    <div class="contract__info">
        <p><span>{%contracts_user-name%}: </span><?php echo $usuario->nombre.' '.$usuario->apellido;?></p>
        <p><span>{%contracts_empresa%}: </span><?php echo $empresa->empresa;?></p>
        <p><span>{%contracts_fecha%}: </span><?php echo $contrato->fecha;?></p>
    </div>
    <!--Create the pdf iframe-->
    <div class="pdf-container">
        <iframe width=100% height=700 id="pdf" src="/contracts/<?php echo $contrato->nombre_doc?>" frameborder="0"></iframe>
    </div>

</div>