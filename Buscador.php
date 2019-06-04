<?php
	namespace Buscador;
	class Buscador{
        var $cs;
        var $top;
        var $query;

        public function __construct(){
            $this->cs = true;
            $this->top = -1;
		}
        public function cargarDatos($ArchivoDatos){
            $Datos = file($ArchivoDatos, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($Datos as $fila => $value){
                $Datos[$fila] = mb_convert_encoding($value, "UTF-8","ISO-8859-1,Windows-1251,UTF-8");
            }
            return $Datos;
		}
        public function ConfigurarBusqueda( $cs, $top ){
            if ($cs == 1)      
                $this->cs = true;
            else
                $this->cs = false;
            if ($top > 0)
                $this->top = $top;
            else
                $this->top = -1;
        }	

        public function Buscar( $Cadena, $Datos){
            $res = array("cantidad" => 0, "datos" => array(), "err"=>"OK");

            if (!$this->cs) // Si es Unsensitive case
                $query = strtoupper($Cadena); 
            else 
                $query = $Cadena;

            $query = str_replace(array(".","?","*"), array("\.",".","(.*)"), $query);
            
            $arr_patron = explode ("(.*)", $query);
            
            $patron = $query;
            if ($arr_patron[count($arr_patron)-1] != '') $patron = $patron . '$';
            if ($arr_patron[0] != '' ) $patron = '^'. $patron;
            if ($arr_patron[0] == '' && $arr_patron[count($arr_patron)-1] == '') $patron = $query;
            
            $patron = "/".$patron."/";
            
            if ($this->cs){ // Si es CaseSensitive
                $resultados = preg_grep($patron, $Datos);
            }else{
                $resultados = preg_grep($patron, array_change_key_case($Datos, CASE_UPPER)); // array_change_key_case($input_array, CASE_UPPER)
            }
            
            if ($this->top > 0){
                $tmp = array_chunk ($resultados, $this->top);
                $res["datos"] = $tmp[0] ? $tmp[0] : array();
            }else{
                $res["datos"] = $resultados;
            }
            
            $res["cantidad"] = count($res["datos"]);

            return $res;
        }	
    }

?>
