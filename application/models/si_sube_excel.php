<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Si_sube_excel extends CI_Model {

    function insert($datos){
            $this->db->insert('preventas', $datos);
    }
	/*function insert($dato1, $dato2, $dato3, $dato4, $dato5, $dato6, $dato7, $dato8, 
                    $dato9, $dato10, $dato11, $dato12, $dato13, $dato14, $dato15, $dato16, $dato17, $dato18, 
                    $dato19, $dato20, $dato21, $dato22, $dato23, $dato24, $dato25, $dato26, $dato27, $dato28,
                    $dato29, $dato30, $dato31, $dato32, $dato33, $dato34, $dato35, $dato36, $dato37, $dato38,
                    $fecha_pre
                    ){
			$this->db->insert('preventas', array (
				'cd' => $dato1,
				'planilla' => $dato2,
				'estado' => $dato3,
				'fecha' => $dato4,               
                'transportista' => $dato5,
                'descr_1' => $dato6,
                'c_camion' => $dato7,
                'viaje' => $dato8,
                'zona_entrega' => $dato9,
                'descr_2' => $dato10,
                'oficina' => $dato11,
                'descr_3' => $dato12,
                'preventista' => $dato13,
                'id_cliente' => $dato14,
                'rut' => $dato15,
                'razon_social' => $dato16,
                'calle' => $dato17,
                'numero' => $dato18,
                'ciudad' => $dato19,
                'comuna' => $dato20,
                'tipo_factura' => $dato21,
                'descr_4' => $dato22,
                'uen' => $dato23,
                'rsc' => $dato24,
                'categoria' => $dato25,
                'marca' => $dato26,
                'tamaño' => $dato27,
                'producto' => $dato28,
                'descr_prod' => $dato29,
                'unidad' => $dato30,
                'cantidad' => $dato31,
                'peso_caja' => $dato32,
                'peso_total' => $dato33,
                'porc_descuento' => $dato34,
                'valor_linea' => $dato35,
                'mensaje_fac' => $dato36,
                'mont_anu' => $dato37,
                'desc_anulacion' => $dato38,
                'fecha_preventa' =>$fecha_pre,
			));}*/

	function inserta_rechazo($datos){
			$this->db->insert('rechazos', $datos);
	}

	function consultar_registro($fecha){
		$this->db->select('*');
		$this->db->from('preventas');
		$this->db->where('fecha_preventa', $fecha);
		$query = $this->db->get();
		if ($query->num_rows > 0) {
			return 1;
		}else{
			return 0;
		}
    }

    function consultar_registro_rechazo($fecha2){
        $this->db->select('*');
        $this->db->from('rechazos');
        $this->db->where('fecha_subida', $fecha2);
        $query = $this->db->get();
        if ($query->num_rows > 0) {
            return 1;
        }else{
            return 0;
        }
    }
    //consolidado_preventa

    function agrupar_cajas_preventa($fecha_resumen_preventa){
        $this->db->select('c_camion as camion, sum(cantidad) as cajas, fecha as fecha, count( distinct id_cliente) as clientes');
        $this->db->from('preventas');
        $this->db->where('fecha', $fecha_resumen_preventa);
        $this->db->group_by('c_camion');
        $query = $this->db->get();
        return $query->result();
    }

    function guardar_preventa($resumen_prenvetas){
        $this->db->insert('resumen_preventa', $resumen_prenvetas);
    }

    function agrupar_cajas_rechazo($fecha_resumen_rechazo){// para mostrar en un label los descuentos
        $this->db->select('camion , sum(suma_de_cajas) as cajas, fecha_factura as fecha, 
                count( distinct cod_cliente) as clientes, carga as vuelta, cod_motivo' );
        $this->db->from('rechazos');
        $this->db->where('fecha_factura', $fecha_resumen_rechazo);
        $this->db->group_by('camion, vuelta');
        $query = $this->db->get();
        return $query->result();
    }    

    function rechazos_total($fecha_resumen_rechazo){// para mostrar en un label los descuentos
        $this->db->select(' sum(suma_de_cajas) as cajas, fecha_factura as fecha');
        $this->db->from('rechazos');
        $this->db->where('fecha_factura', $fecha_resumen_rechazo);
        $query = $this->db->get();
        return $query->result();
    }

    function guardar_rechazo($resumen_rechazos){
        $this->db->insert('resumen_rechazo', $resumen_rechazos);
    }

    function obtener_ingreso_produccion($fecha_php){
        $this->db->select('*');
        $this->db->from('ingreso_produccion');
        $this->db->where('fecha_registro', $fecha_php);
        $query = $this->db->get();
        return $query->result();
    }

    function consultar_vuelta($vuelta, $fecha, $idcamion){
        $this->db->select('*');
        $this->db->from('ingreso_produccion');
        $this->db->where('vuelta', $vuelta);
        $this->db->where('fecha_registro',$fecha);
        $this->db->where('id_camion',$idcamion);
        $query = $this->db->get();
        return $query->row();
    }

    function actualizar_ingreso_produccion($id, $data){
        $this->db->where('id',$id);
        $this->db->update('ingreso_produccion', $data);
    }
    function cambiar_estado($fecha, $estado){
        $this->db->where('fecha_registro',$fecha);
        $this->db->update('ingreso_produccion', $estado);
    }

    function get_registro_produccion($id){
        $this->db->select('*');
        $this->db->from('ingreso_produccion');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function get_registro_produccions($id){
        $this->db->select('*');
        $this->db->from('ingreso_produccion');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function setBonoRechazo($data){
         $this->db->insert('bono_rechazos', $data);

    }
    function prueba($data){
           $this->db->insert('prueba', $data);
    }









    //***************************************** funciones para actualizar los rechazos desde 1 de junio->

    function consultar_rechazos_junio(){
        $this->db->select('camion , sum(suma_de_cajas) as cajas, fecha_factura as fecha, count( distinct cod_cliente) as clientes, carga');
        $this->db->from('rechazos');
        $this->db->where('fecha_factura between "2017-06-01" and "2017-06-18"');// fecha a actualizar antes de implementado el sistema
        $this->db->group_by('camion, carga, fecha_factura');
        $query = $this->db->get();
        return $query->result();
    }

    function consultar_id_sccu($s_ccu){
        $this->db->select('*');
        $this->db->from('codigos_ccu');
        $this->db->where('codigos_ccu', $s_ccu);
        $query = $this->db->get();
        return $query->row();
    }



    function probando($datos4){
        $this->db->insert('preventas',$datos4);




    }

    function buscar_nombre_camiones(){
        $this->db->select('*');
        $this->db->where('eliminado',1);
        $this->db->from('codigos_ccu');
        $query = $this->db->get();
        return $query->result();
    }




}

/* End of file si_sube_ecxel.php */
/* Location: ./application/models/si_sube_ecxel.php */