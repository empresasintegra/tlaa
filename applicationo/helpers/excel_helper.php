<?php 
if ( ! function_exists('importar_eval_largo'))
{
	function importar_eval_largo($_archivo,$_texto,$_asociacion)
	{
		$CI =& get_instance();
		$CI->load->model("Evaluacionestipo_model");
		$CI->load->model("Evaluacionesevaluacion_model");
		$CI->load->model("Evaluaciones_model");
		$CI->load->model("Planta_model");
		$CI->load->model("Cargos_model");
		$CI->load->model("Areas_model");
		$CI->load->model("Usuarios_model");
		$CI->load->library('PHPExcel');
		$CI->load->library('PHPExcel/IOFactory');
		
		$objPHPExcel = new PHPExcel();
		$objReader = IOFactory::load(BASE_URL2.$_archivo);
		
		foreach ($objReader->getWorksheetIterator() as $worksheet) {
		    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
		    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$highestColumnIndex = (int)$highestColumnIndex;
			for ($row = 1; $row <= 1; $row++){
		        for($col = 0; $col < $highestColumnIndex; $col++) {
		            $cell = $worksheet->getCellByColumnAndRow($col, $row);
		            $val = $cell->getValue();
					if($val != ""){
						$lista_arr[] = $val;
					}
		        }
		    }
		}
		
		if(!array_diff($_texto, $lista_arr)){
			foreach ($objReader->getWorksheetIterator() as $worksheet) {
			    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$consulta = " INSERT INTO evaluaciones (";
				$lista_aux = $_texto;
				array_splice($lista_aux,2,1);
				$x = 0; //aux contador al for
				for ($row = 1; $row < 2; $row++) {
			        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			        	$x++;
			            $cell = $worksheet->getCellByColumnAndRow($col, $row);
			            $val = trim($cell->getValue());
						if($val != "TIPO EVALUACION"){
							$key = array_keys($lista_aux, $val);
							$consulta .= $_asociacion[$key[0]];
							if($x < $highestColumnIndex) $consulta .= ", ";
						}
						//verificar la posicion de todas las columnas que tienen ID'S
						if($val == "PLANTA") $key_planta = $col;
						if($val == "RUT") $key_rut = $col;
						if($val == "TIPO EVALUACION") $key_tipo = $col;
						if($val == "EVALUACION") $key_evaluacion = $col;
						if($val == "CARGO") $key_cargo = $col;
						if($val == "FECHA EVALUACION") $key_fecha_e = $col;
						if($val == "FAENA") $key_faena = $col;
						if($val == "AREA") $key_area = $col;
						if($val == "RESULTADO") $key_resultado = $col;
						if($val == "RECOMIENDA") $key_recomienda = $col;
						if($val == "OBSERVACIONES") $key_observaciones = $col;
			        }
			    }
				$consulta .= " ) VALUES ";
				$values = array();
				$error = 0;
				$i = 0;
				//VALIDAR!
				for ($row = 2; $row <= $highestRow; $row++) {
					$values[$i] = "";
					for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
			            $val = trim($cell->getValue());
						if(empty($val)){
							$noinsert[$i]['fila'] = $row;
							$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
							$noinsert[$i]['motivo'][$col]['texto'] = "Existe un dato vacio, ¡Todos son obligatorios!";
							$error = 1;
							continue;
						}
						$val = mb_strtoupper($val);
						if( $key_planta == $col){
							if(!$pl = $CI->Planta_model->get_nombre($val) ){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "La planta no existe en la base de datos";
								$error = 1;
								continue;
							}
							else{
								$planta_error = $pl->id;
								$values[$i].= $pl->id.",";
							}
						}
						if( $key_rut == $col){
							$rut_error = $val; 
							if(!$r=$CI->Usuarios_model->get_rut($val) ){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El rut no existe en la base de datos";
								$error = 1;
								continue;
							}
							else{
								$values[$i].= $r->id.",";
							}
						}
						if($key_tipo == $col){
							if(!$tp = $CI->Evaluacionestipo_model->get_nombre( mb_strtoupper($val,'UTF-8') )){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El tipo de evaluación no existe en la base de datos";
								$error = 1;
								continue;
							}
							else{
								$id_tipo_error = $tp->id;
							}
						}
						if($key_evaluacion == $col){
							if(!$ev = $CI->Evaluacionesevaluacion_model->get_nombre( mb_strtoupper($val,'UTF-8') )){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El nombre de evaluación no existe en la base de datos";
								$error = 1;
								continue;
							}
							else{
								$tiene = 0;
								$e = $CI->Evaluacionesevaluacion_model->get_tipo($ev->id);
								foreach( $e as $e){
									if($e->nombre == mb_strtoupper($val,'UTF-8') ) $tiene = 1;
								}
								if($tiene == 0 ){
									$noinsert[$i]['fila'] = $col;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "El nombre de la evaluación no tiene asociación con el tipo";
									$error = 1;
									continue;
								}
								else{
									$values[$i].= $e->id.",";
								}
							}
						}
						if($key_cargo == $col){
							if(!$c=$CI->Cargos_model->get_eval($planta_error,mb_strtoupper($val,'UTF-8'))){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El cargo no existe en la planta indicada";
								$error = 1;
								continue;
							}
							else{
								$values[$i].= $c->id.",";
							}
						}
						if($key_fecha_e == $col){
							$txn_date = PHPExcel_Shared_Date::ExcelToPHP($val);
							$values[$i].= date('\'Y-m-d\'', $txn_date).",";
						}
						if($key_faena == $col){
							$values[$i].= "\"$val\"".",";
						}
						if($key_area == $col){
							if(!$a=$CI->Areas_model->get_eval($planta_error,mb_strtoupper($val,'UTF-8'))){
								$noinsert[$i]['rut'] = $rut_error;
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El area no existe en la planta indicada";
								$error = 1;
								continue;
							}
								else{
									$values[$i].= $a->id.",";
								}
						}
						if($key_resultado == $col){
							if(!is_numeric($val)){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El resultado debe ser numérico";
								$error = 1;
								continue;
							}
							else{
								$values[$i].= $val.",";
							}
						}
						if($key_recomienda == $col){
							if( ($val != "SI") && ($val != "NO") ){ // verificar validacion
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "La recomendación debe ser SI o NO";
								$error = 1;
								continue;
							}
							else{
								if($val == "SI") $values[$i] .= "1,";
								if($val == "NO") $values[$i] .= "0,";
							}
						}
						if($key_observaciones == $col){
							if(empty($val))
								$values[$i] .= 'NULL';
							else
								$values[$i] .= "\"$val\"";
						}
					}
					$i++;
				}
			}
		$total_asc = count($_asociacion);
		$total_val = count($values);
		$cont_errores = 0;
		$cont_repetidos = 0;
		for($d=0;$d<$total_val;$d++){
			$s = explode(",",$values[$d]);
			if(count($s) < ($total_asc-1)){
				$cont_errores++;
				$erroneos[] = $noinsert[$d];
			}
			else{
				$manual = "SELECT * FROM evaluaciones WHERE id_planta = ".$s[0]." AND id_usuarios = ".$s[1]." AND id_evaluacion = ".$s[2]." AND id_cargo = ".$s[3]." AND fecha_e = ".$s[4]." AND faena = ".$s[5]." AND id_area = ".$s[6]." AND resultado = ".$s[7]." AND recomienda = ".$s[8]." AND observaciones = ";
				if(empty($s[9])){ $manual.= 'IS NULL'; } else{ $manual .= '='.$s[9]; };
				
				if(count($CI->Evaluaciones_model->select_manual($manual)) > 0){
					$cont_repetidos++;
				}
				else{
					$correcto[] = "(".$values[$d].")";
				}
			}
		}
		die;
		//validar si los correctos ya estan insertados
		$salida['total_errores'] = $cont_errores;
		$salida['totales'] = $total_val;
		$salida['erroneos'] = $erroneos;
		$salida['correcto'] = @$correcto;
		$salida['consulta'] = $consulta;
		$salida['total_repetidos'] = $cont_repetidos;
		
		return $salida;
		
		}
		else{
			return false;// error 1, no coinciden los nombres del excel con los que se piden, los necesarios para que funcione
		}
		
	}
}

if ( ! function_exists('importar_eval_corto'))
{
	function importar_eval_corto($_archivo,$_texto,$_asociacion)
	{
		//echo "lalala";
		$CI =& get_instance();
		$CI->load->model("Evaluacionestipo_model");
		$CI->load->model("Evaluacionesevaluacion_model");
		$CI->load->model("Evaluaciones_model");
		$CI->load->model("Planta_model");
		$CI->load->model("Cargos_model");
		$CI->load->model("Areas_model");
		$CI->load->model("Usuarios_model");
		$CI->load->library('PHPExcel');
		$CI->load->library('PHPExcel/IOFactory');
		
		$objPHPExcel = new PHPExcel();
		$objReader = IOFactory::load(BASE_URL2.$_archivo);
		
		foreach ($objReader->getWorksheetIterator() as $worksheet) {
		    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
		    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$highestColumnIndex = (int)$highestColumnIndex;
			for ($row = 1; $row <= 1; $row++){
		        for($col = 0; $col < $highestColumnIndex; $col++) {
		            $cell = $worksheet->getCellByColumnAndRow($col, $row);
		            $val = trim($cell->getValue());
					if($val != ""){
						$lista_arr[] = $val;
					}
		        }
		    }
		}
		
		if(!array_diff($_texto,$lista_arr)){
			foreach ($objReader->getWorksheetIterator() as $worksheet) {
			    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$consulta = " INSERT INTO evaluaciones (";
				$lista_aux = $_texto;
				//print_r($lista_aux);echo "<br />";
				array_splice($lista_aux,1,1);
				//print_r($lista_aux);echo "<br />";
				$x = 0; //aux contador al for
				for ($row = 1; $row < 2; $row++) {
			        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			            $cell = $worksheet->getCellByColumnAndRow($col, $row);
			            $val = trim($cell->getValue());
						if(!empty($val)){
							if($val != "TIPO EVALUACION"){
								$x++;
								//echo "blabla->>>".$val."<br />";
								//print_r($lista_aux);echo "<br />";
								//echo "val --> ". $val." listaAux--> ".$lista_aux."<br/>";
								$key = array_keys($lista_aux, $val,TRUE);
								//echo "----- asociaciones de array-----<br/>";
								//echo print_r($key);echo "<br />";
								@$consulta .= $_asociacion[$key[0]];
								//echo $_asociacion[$key[0]]."<br />";
								//if($x <= $highestColumnIndex && @isset($_asociacion[$key[0]])) $consulta .= ", ";
								if(count($lista_aux) > ($x)) {$consulta .= ", ";}
							}
							//verificar la posicion de todas las columnas que tienen ID'S
							//if($val == "PLANTA") $key_planta = $col;
							if($val == "RUT") $key_rut = $col;
							if($val == "TIPO EVALUACION") $key_tipo = $col;
							if($val == "EVALUACION") $key_evaluacion = $col;
							if($val == "FECHA EVALUACION") $key_fecha_e = $col;
							if($val == "FECHA VIGENCIA") $key_fecha_v = $col;
							if($val == "RESULTADO") $key_resultado = $col;
							if($val == "OBSERVACIONES") $key_observaciones = $col;
						}
			        }
			    }
				$consulta .= " ) VALUES ";
				$values = array();
				$error = 0;
				$i = 0;
				//VALIDAR!
				for ($row = 2; $row <= $highestRow; $row++) {
					$values[$i] = "";
					for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
			            $val = trim($cell->getValue());
						// if(empty($val)){
							// $noinsert[$i]['fila'] = $row;
							// $noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
							// $noinsert[$i]['motivo'][$col]['texto'] = "Existe un dato vacio, ¡Todos son obligatorios!";
							// $error = 1;
							// continue;
						// }
						$val = mb_strtoupper($val);
						// if( $key_planta == $col){
							// if(!$pl = $CI->Planta_model->get_nombre($val) ){
								// $noinsert[$i]['fila'] = $row;
								// $noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								// $noinsert[$i]['motivo'][$col]['texto'] = "La planta no existe en la base de datos";
								// $error = 1;
								// continue;
							// }
							// else{
								// $planta_error = $pl->id;
								// $values[$i].= $pl->id.",";
							// }
						// }
						if( $key_rut == $col){
							$rut_error = $val; 
							if(!$r=$CI->Usuarios_model->get_rut($val) ){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El rut no existe en la base de datos";
								$error = 1;
								continue;
							}
							else{
								$values[$i].= $r->id.",";
							}
						}
						if($key_tipo == $col){
							$tp = $CI->Evaluacionestipo_model->get_nombre( mb_strtoupper($val,'UTF-8') );
							if(empty($tp)){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El tipo de evaluación no existe en la base de datos";
								$error = 1;
								continue;
							}
							else{
								$id_tipo_error = $tp->id;
								$id_tipo = $tp->id;
							}
						}
						if($key_evaluacion == $col){
							$ev =  $CI->Evaluacionesevaluacion_model->get_nombre( mb_strtoupper($val,'UTF-8'));
							if(!$ev){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El nombre de evaluación no existe en la base de datos";
								$error = 1;
								continue;
							}
							else{
								$tiene = 0;
								$e = $CI->Evaluacionesevaluacion_model->get_tipo($id_tipo);
								
								foreach( $e as $e){
									if($e->nombre == mb_strtoupper($val,'UTF-8') ) $tiene = 1;
								}
								if($tiene == 0 ){
									$noinsert[$i]['fila'] = $col;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "El nombre de la evaluación no tiene asociación con el tipo o el tipo esta despues del nombre de la evaluacion";
									$error = 1;
									continue;
								}
								else{
									$values[$i].= $e->id.",";
								}
							}
						}
						if($key_fecha_e == $col){
							$txn_date = PHPExcel_Shared_Date::ExcelToPHP($val);
							$values[$i].= date('\'Y-m-d\'', $txn_date).",";
						}
						if($key_fecha_v == $col){
							if(empty($val)){
								$values[$i].= '\'0000-00-00\''.',';
							}
							else{
 								$txn_date = PHPExcel_Shared_Date::ExcelToPHP($val);
								$values[$i].= date('\'Y-m-d\'', $txn_date).",";
							}
						}
						if($key_resultado == $col){
							if(is_numeric($val) || $val == "SI" || $val == "NO" || $val == "APROBADO" || $val == "RECHAZADO" || 
							$val == "SIN CONTRAINDICACIONES" || $val == "CON CONTRAINDICACIONES" ){
								if(is_numeric($val)) $values[$i].= $val.",";
								if($val == "SI") $values[$i].= "1,";
								if($val == "APROBADO") $values[$i].= "0,";
								if($val == "RECHAZADO") $values[$i].= "1,";
								if($val == "SIN CONTRAINDICACIONES") $values[$i].= "0,";
								if($val == "CON CONTRAINDICACIONES") $values[$i].= "1,";
								
							}
							else{
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El resultado no puede ser numerico";
								$error = 1;
								continue;
							}
						}
						if($key_observaciones == $col){
							if(empty($val))
								$values[$i] .= 'NULL';
							else
								$values[$i] .= "\"$val\"";
						}
					}
					$i++;
				}
			}
		$total_asc = count($_asociacion);
		$total_val = count($values);
		$cont_errores = 0;
		$cont_repetidos = 0;
		$cont_repetidos_excel = 0;
		for($d=0;$d<$total_val;$d++){
			$s = explode(",",$values[$d]);
			if(count($s) < ($total_asc)){
				$cont_errores++;
				$erroneos[] = $noinsert[$d];
			}
			else{
				$manual = "SELECT * FROM evaluaciones WHERE id_usuarios = ".$s[0]." AND id_evaluacion = ".$s[1]." AND fecha_e = ".$s[2]." AND fecha_v = ".$s[3]." AND resultado = ".$s[4]." AND observaciones ";
				$s[5] = trim($s[5]);
				if(strlen($s[5]) < 1 || $s[5] == 'NULL'){ $manual.= 'IS NULL'; } else{ $manual .= '= '.$s[5]; }
				if(count($CI->Evaluaciones_model->select_manual($manual)) > 0){
					$cont_repetidos++;
				}
				else{
					$correcto[] = "(".$values[$d].")";
				}
			}
		}
		$total_correctos = @count($correcto);
		$nuevo_correcto = @array_unique($correcto,SORT_STRING);
		$total_nuevo_correcto = count($nuevo_correcto);
		$cont_repetidos_excel = $total_correctos - $total_nuevo_correcto;
		
		//validar si los correctos ya estan insertados
		$salida['total_errores'] = $cont_errores;
		$salida['totales'] = $total_val;
		$salida['erroneos'] = @$erroneos;
		$salida['correcto'] = @$nuevo_correcto;
		$salida['consulta'] = $consulta;
		$salida['total_repetidos'] = $cont_repetidos;
		$salida['repetidos_excel'] = $cont_repetidos_excel;
		return $salida;
		
		}
		else{
			return false;// error 1, no coinciden los nombres del excel con los que se piden, los necesarios para que funcione
		}
		
	}
}
if ( ! function_exists('importar_trabajadores'))
{
	function importar_trabajadores($_archivo,$_texto,$_asociacion)
	{
		$CI =& get_instance();
		$CI->load->model("Usuarios_model");
		$CI->load->model("Bancos_model");
		$CI->load->model("Region_model");
		$CI->load->model("Provincia_model");
		$CI->load->model("Ciudad_model");
		$CI->load->model("Estadocivil_model");
		$CI->load->model("Profesiones_model");
		$CI->load->model("Especialidadtrabajador_model");
		$CI->load->model("Afp_model");
		$CI->load->model("Excajas_model");
		$CI->load->model("Salud_model");
		$CI->load->model("Nivelestudios_model");
		$CI->load->library('PHPExcel');
		$CI->load->library('PHPExcel/IOFactory');
		
		$objPHPExcel = new PHPExcel();
		$objReader = IOFactory::load(BASE_URL2.$_archivo);
		
		foreach ($objReader->getWorksheetIterator() as $worksheet) {
		    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
		    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
		    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
			$highestColumnIndex = (int)$highestColumnIndex;
			for ($row = 1; $row <= 1; $row++){
		        for($col = 0; $col < $highestColumnIndex; $col++) {
		            $cell = $worksheet->getCellByColumnAndRow($col, $row);
		            $val = trim($cell->getValue());
					if($val != ""){
						$lista_arr[] = $val;
					}
		        }
		    }
		}
		
		if(!array_diff($_texto,$lista_arr )){
			foreach ($objReader->getWorksheetIterator() as $worksheet) {
			    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
			    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$consulta = " INSERT INTO usuarios (";
				$x = 0; //aux contador al for
				for ($row = 1; $row < 2; $row++) {
			        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
			        	$x++;
			            $cell = $worksheet->getCellByColumnAndRow($col, $row);
			            $val = trim($cell->getValue());
						$key = array_keys($_texto, $val);
						$consulta .= $_asociacion[$key[0]];
						if($x < $highestColumnIndex) $consulta .= ", ";
						//verificar la posicion de todas las columnas que tienen ID'S
						if($val == "RUT") $key_rut = $col;
						if($val == "NOMBRES") $key_nombre = $col;
						if($val == "APELLIDO PATERNO") $key_paterno = $col;
						if($val == "APELLIDO MATERNO") $key_materno = $col;
						if($val == "DIRECCIÓN") $key_direccion = $col;
						if($val == "CORREO ELECTRÓNICO") $key_correo = $col;
						if($val == "TELÉFONO") $key_fono = $col;
						if($val == "TELÉFONO 2") $key_fono2 = $col;
						if($val == "REGIÓN") $key_region = $col;
						if($val == "CIUDAD") $key_ciudad = $col;
						if($val == "PROVINCIA") $key_provincia = $col;
						if($val == "FECHA NACIMIENTO") $key_nacimiento = $col;
						if($val == "NACIONALIDAD") $key_nacionalidad = $col;
						if($val == "SEXO") $key_sexo = $col;
						if($val == "ESTADO CIVIL") $key_civil = $col;
						if($val == "PROFESION") $key_profesion = $col;
						if($val == "BANCO") $key_banco = $col;
						if($val == "TIPO DE CUENTA") $key_tipobanco = $col;
						if($val == "NUMERO DE CUENTA") $key_numerobanco = $col;
						if($val == "ESPECIALIDAD 1") $key_especialidad1 = $col;
						if($val == "ESPECIALIDAD 2") $key_especialidad2 = $col;
						if($val == "ESPECIALIDAD 3") $key_especialidad3 = $col;
						if($val == "AFP") $key_afp = $col;
						if($val == "EXCAJA") $key_excaja = $col;
						if($val == "SALUD") $key_salud = $col;
						if($val == "NUMERO DE ZAPATO") $key_zapato = $col;
						if($val == "TALLA DE BUZO") $key_talla = $col;
						if($val == "LICENCIA") $key_licencia = $col;
						if($val == "ESTUDIOS") $key_estudios = $col;
						if($val == "INSTIUCIÓN") $key_institucion = $col;
						if($val == "AÑO DE EGRESO") $key_egreso = $col;
						if($val == "AÑOS DE EXPERIENCIA") $key_experiencia = $col;
						if($val == "CURSOS") $key_cursos = $col;
						if($val == "EQUIPOS") $key_equipos = $col;
						if($val == "SOFTWARE") $key_software = $col;
						if($val == "IDIOMAS") $key_idiomas = $col;
			        }
			    }
				$consulta .= ",clave,id_tipo_usuarios ) VALUES ";
				$values = array();
				$error = 0;
				$i = 0;
				//VALIDAR!
				for ($row = 2; $row <= $highestRow; $row++) {
					$values[$i] = "";
					for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						//echo $col;
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
			            $val = trim($cell->getValue());
						$val = mb_strtoupper($val);
						if( $key_rut == $col){
							$rut_error = $val; 
							if( empty($val) ){
								$noinsert[$i]['fila'] = $row;
								$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
								$noinsert[$i]['motivo'][$col]['texto'] = "El rut no puede estar vacio!!";
								$error = 1;
								continue;
							}
							else{
								$values[$i].= "\"$val\"".",";
								$rut = $val;
								$xp = "";
								$np = "";
								$tp = explode(".",$val);
								foreach($tp as $p){ $xp .= $p; }
								$pass = explode('-',$xp);
								foreach($pass as $p){$np .= $p;}
								$pass = $np;
							}
						}
						if($key_nombre == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_paterno == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_materno == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_direccion == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_correo == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_fono == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else{
								$fn = explode('-',$val);
								if( count($fn) < 2 ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "El telefono tiene un error, fata el codigo (09-xxxxxx u 041-xxxxxx)";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else
									$values[$i].= "\"$val\"".",";
							}
						}
						if($key_fono2 == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else{
								$fn = explode('-',$val); 
								if( count($fn) < 2 ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "El telefono tiene un error, fata el codigo (09-xxxxxx u 041-xxxxxx)";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else
									$values[$i].= "\"$val\"".",";
							}
						}
						if($key_region == $col){
							if(!empty($val)){
								if(!$r = $CI->Region_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La región no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $r->id.",";
								}
							}
						}
						if($key_ciudad == $col){
							if(!empty($val)){
								if(!$c = $CI->Ciudad_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La ciudad no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $c->id.",";
								}
							}
						}
						if($key_provincia == $col){
							if(!empty($val)){
								if(!$p = $CI->Provincia_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La provincia no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $p->id.",";
								}
							}
						}
						if($key_nacimiento == $col){
							if(!empty($val)){
								$txn_date = PHPExcel_Shared_Date::ExcelToPHP($val);
								$values[$i] .= date('\'Y-m-d\'', $txn_date).",";;
							}
						}
						if($key_nacionalidad == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						} 
						if($key_sexo == $col){
							if(!empty($val)){
								if($val == "MASCULINO") $values[$i] .= '0'.",";;
								if($val == "FEMENINO") $values[$i] .= '1'.",";;
							}
						}
						if($key_civil == $col){
							if(!empty($val)){
								if(!$c = $CI->Estadocivil_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "El estado civil no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $c->id.",";
								}
							}
						}
						if($key_profesion == $col){
							if(!empty($val)){
								if(!$p = $CI->Profesiones_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La profesión no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $p->id.",";
								}
							}
						}
						if($key_banco == $col){
							if(!empty($val)){
								if(!$b = $CI->Bancos_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "El banco no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $b->id.",";
								}
							}
						}
						if($key_tipobanco == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_numerobanco == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_especialidad1 == $col){
							if(!empty($val)){
								if(!$e = $CI->Especialidadtrabajador_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La especialidad no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $e->id.",";
								}
							}
							else{
								$values[$i].= "NULL,";
							}
						}
						if($key_especialidad2 == $col){
							if(!empty($val)){
								if(!$e = $CI->Especialidadtrabajador_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La especialidad no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $e->id.",";
								}
							}
							else{
								$values[$i].= "NULL,";
							}
						}
						if($key_especialidad3 == $col){
							if(!empty($val)){
								if(!$e = $CI->Especialidadtrabajador_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La especialidad no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $e->id.",";
								}
							}
							else{
								$values[$i].= "NULL,";
							}
						}
						if($key_afp == $col){
							if(!empty($val)){
								if(!$a = $CI->Afp_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La afp no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $a->id.",";
								}
							}
						}
						if($key_excaja == $col){
							if(!empty($val)){
								if(!$e = $CI->Excajas_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "La excaja no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $e->id.",";
								}
							}
							else{
								$values[$i].= "NULL,";
							}
						}
						if($key_salud == $col){
							if(!empty($val)){
								if(!$s = $CI->Salud_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "El sistema de salud no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $s->id.",";
								}
							}
						}
						if($key_zapato == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_talla == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_licencia == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_estudios == $col){
							if(!empty($val)){
								if(!$n = $CI->Nivelestudios_model->buscar(mb_strtoupper($val,'UTF-8')) ){
									$noinsert[$i]['fila'] = $row;
									$noinsert[$i]['motivo'][$col]['columna'] = $col + 1;
									$noinsert[$i]['motivo'][$col]['texto'] = "El nivel de estudios no existe en la base de datos";
									$error = 1;
									$values[$i] = "";
									continue;
								}
								else{
									$values[$i].= $n->id.",";
								}
							}
						}
						if($key_institucion == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_egreso == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_experiencia == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_cursos == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_equipos == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_software == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
						if($key_idiomas == $col){
							if(empty($val))
								$values[$i].= "NULL,";
							else
								$values[$i].= "\"$val\"".",";
						}
					}
					if($rut_error){
						$values[$i] .= "'".hash('sha512',$pass)."',2";
					}
					$i++;
				}
			}
		$total_asc = count($_asociacion);
		$total_val = count($values);
		$cont_errores = 0;
		$cont_repetidos = 0;
		for($d=0;$d<$total_val;$d++){
			$s = explode(",",$values[$d]);
			if(count($s) < ($total_asc)){
				//echo "lala";
				$cont_errores++;
				$erroneos[] = $noinsert[$d];
			}
			else{
				if(!$CI->Usuarios_model->get_rut($s[0])){
					$correcto[] = "(".$values[$d].")";
				}
				else{
					$cont_repetidos++;
				}
			}
		}
		//validar si los correctos ya estan insertados
		$salida['total_errores'] = $cont_errores;
		$salida['totales'] = $total_val;
		$salida['erroneos'] = @$erroneos;
		$salida['correcto'] = @$correcto;
		$salida['consulta'] = $consulta;
		$salida['total_repetidos'] = $cont_repetidos;
		
		return $salida;
		
		}
		else{
			return false;// error 1, no coinciden los nombres del excel con los que se piden, los necesarios para que funcione
		}
	}
}
?>