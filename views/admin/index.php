<?php 
    include __DIR__."/../templates/barra.php"
?>
<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="form">
        <div class="campo">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha;?>">
        </div>
    </form>
</div>
<?php 
            if(count($citas)<1){?>
                <h3>No Hay Citas Para Esta Fecha</h3>
               
          <?php 
        }
        ?>
<div class="citas">
    <ul class="citas-lista">
       
<?php 
    $id=0;
    $i=1;
        foreach($citas as $key=>$cita):
            if($id!=$cita->idcita):
                $total=0;
            ?>
                <li class="cita">
                    <h3> Datos de Cita(s) <?php echo $fecha?></h3>
                    <p>Hora:<span><?php echo $cita->hora; ?> </span></p>
                    <p>Cliente:<span><?php echo $cita->cliente; ?></span> </p>
                    <p>Email:<span><?php echo $cita->email; ?></span> </p>
                    <p>Telefono:<span><?php echo $cita->telefono; ?></span> </p>
                
                    <h3>Servicios</h3>
                    <div class="servicios">
            <?php         
                    $id=$cita->idcita;
            endif;
            $total+=number_format($cita->precio);
            ?>
                        <p ><?php echo $cita->servicio . " <span>-- $ </span>".$cita->precio; ?></p>
                
            <?php 
            if($id!=$citas[$key+1]->idcita || $i==count($citas)):
            ?>
                        <p><span>Total:</span> $<?php echo $total;?></p>
                        <form action="/api/borrar-cita" method="POST">
                            <input type="hidden" id='idcita' name="idcita" value="<?php echo $cita->idcita;?>" >
                            <input type="submit" value="Eliminar" class="boton-rojo">
                        </form>
                    </div>
                </li>
            <?php 
            endif;
            $i++;
        endforeach;?>
    </ul>
</div>
 <?php 
     $script="<script src='build/js/buscador.js'></script>";
?> 