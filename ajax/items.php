<?php
$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	if (isset($_REQUEST['id'])){
		$id=intval($_REQUEST['id']);
		$delete=mysqli_query($con,"delete from tmp where id='$id'");
	}
	
	if (isset($_POST['descripcion'])){
		echo $codigo=mysqli_real_escape_string($con,$_POST['codigo']);
		$descripcion=mysqli_real_escape_string($con,$_POST['descripcion']);
		$cantidad=intval($_POST['cantidad']);
		$precio=floatval($_POST['precio']);
		$sql="INSERT INTO `tmp` (`id`, `codigo`, `descripcion`, `cantidad`, `precio`) VALUES (NULL, '$codigo','$descripcion', '$cantidad', '$precio');";
		$insert=mysqli_query($con,$sql);
		
	}
	$query_perfil=mysqli_query($con,"select * from perfil where id=1");
	$rw=mysqli_fetch_assoc($query_perfil);
	
	
	$query=mysqli_query($con,"select * from tmp order by id");
	$items=1;
	$suma=0;
	while($row=mysqli_fetch_array($query)){
			$total=$row['cantidad']*$row['precio'];
			$total=number_format($total,2,'.','');
		?>
	<tr>
		<td class='text-center'><?php echo $row['codigo'];?></td>
		<td><?php echo $row['descripcion'];?></td>
		<td class='text-center'><?php echo $row['cantidad'];?></td>
		<td class='text-right'><?php echo $row['precio'];?></td>
		<td class='text-right'><?php echo $total;?></td>
		<td class='text-right'><a href="#" onclick="eliminar_item('<?php echo $row['id']; ?>')" ><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAeFBMVEUAAADnTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDznTDx+VWpeAAAAJ3RSTlMAAQIFCAkPERQYGi40TVRVVlhZaHR8g4WPl5qdtb7Hys7R19rr7e97kMnEAAAAaklEQVQYV7XOSQKCMBQE0UpQwfkrSJwCKmDf/4YuVOIF7F29VQOA897xs50k1aknmnmfPRfvWptdBjOz29Vs46B6aFx/cEBIEAEIamhWc3EcIRKXhQj/hX47nGvt7x8o07ETANP2210OvABwcxH233o1TgAAAABJRU5ErkJggg=="></a></td>
	</tr>	
		<?php
		$items++;
		$suma+=$total;
		
	}
	
		$neto=$suma;
		$iva=$rw['iva'] / 100;
		$total_iva=$neto * $iva;
		$suma=$neto+$total_iva;
	?>
	<tr>
		<td colspan='6'>
		
			<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Agregar producto</button>
		</td>
	</tr>
	<tr>
		<th colspan='4' class='text-right'>
			NETO <?php echo $rw['moneda'];?>
		</th>
		<th class='text-right'>
			<?php echo number_format($neto,2);?>
		</th>
		<td></td>
	</tr>
	
	<tr>
		<th colspan='4' class='text-right'>
			IVA (<?php echo $rw['iva'];?>%) <?php echo $rw['moneda'];?> 
		</th>
		<th class='text-right'>
			<?php echo number_format($total_iva,2);?>
		</th>
		<td></td>
	</tr>
	
	<tr>
		<th colspan='4' class='text-right'>
			TOTAL <?php echo $rw['moneda'];?>
		</th>
		<th class='text-right'>
			<?php echo number_format($suma,2);?>
		</th>
		<td></td>
	</tr>
<?php

}