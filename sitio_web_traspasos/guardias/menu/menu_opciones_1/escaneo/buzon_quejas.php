<html>
<head>
	<meta charset="UTF-8">
	<title>Formularios</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<h1 class="text-center">Libro de reclamaciones</h1>
		<form class="col-sm-6 col-sm-offset-3" action="reclamacion.php" method="POST">
			<div class="form-group">
				<label>Nombre *</label>
				<input type="text" class="form-control" placeholder="Ej. Cesar">
			</div>
			<div class="form-group">
				<label>Apellido *</label>
				<input type="text" class="form-control" placeholder="Ej. Aquino Maximiliano">
			</div>
			<div class="form-group">
				<label>Dirección *</label>
				<input type="text" class="form-control" placeholder="Ej. Av. Los Angeles 1025">
			</div>
			<div class="form-group">
				<label>Distrito *</label>
				<input type="text" class="form-control" placeholder="Ej. Villa El Salvador">
			</div>
			<div class="form-group">
				<label>Documento de Identidad*</label>
				<select class="form-control">
					<option>-Ninguno-</option>
					<option value="D.N.I.">D.N.I.</option>
					<option value="C.E.">C.E.</option>
					<option value="Menor de edad">Menor de edad</option>
				</select>
			</div>
			<div class="form-group">
				<label>N° doc. Identidad *</label>
				<input type="text" class="form-control" placeholder="Ej. 40125201">
			</div>
			<div class="form-group">
				<label>Correo electrónico *</label>
				<input type="email" class="form-control" placeholder="Ej. nombre@correo.com">
			</div>
			<div class="form-group">
				<label>Teléfono alternativo *</label>
				<input type="text" class="form-control" placeholder="Ej. 1 294-0008">
			</div>
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-md-3">Papá Mamá *</label>
					<div class="col-md-9">
						<input type="text" class="form-control" placeholder="Ej. Luis">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Monto a reclamar (S/.)</label>
				<input type="text" class="form-control" placeholder="Ej. 200">
			</div>
			<label class="radio-inline">
				<input type="radio" name="tipo" checked> Producto
			</label>
			<label class="radio-inline">
				<input type="radio" name="tipo"> Servicio
			</label>
			<div class="form-group">
				<label>Descripcion</label>
				<textarea class="form-control" rows="5"></textarea>
			</div>
			<input type="submit" class="btn btn-block btn-lg btn-primary">
		</form>

		<?php
		
		$querys = "SELECT DISTINCT nombre_producto FROM tb_detalle_carga_tpt WHERE uuid_cabecero_carga_tpt = '2ae79afb-1b61-4809-9a80-cadb8cd5b21a' AND numero_documento <> '-';

		select distinct nombre_producto from tb_detalle_carga_tpt where uuid_cabecero_carga_tpt = '2ae79afb-1b61-4809-9a80-cadb8cd5b21a';";

		$consulta = mysqli_query($conexion, $querys);

		if (mysqli_num_rows($consulta) > 0 ) {
			
			while ($fila = mysqli_fetch_assoc($consulta)){

				

			}

		}else {

			echo "No se encontro ningun registro<br>";

		}

		?>
	</div>
</body>
</html>