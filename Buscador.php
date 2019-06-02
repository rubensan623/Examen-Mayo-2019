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
            return file($ArchivoDatos, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
                $resultados = array_chunk ($resultados, $this->top);
                if (count($resultados)>0)
                    $res = $resultados[0];
                else $res = array();
            }else{
                $res = $resultados;
            }
        
            return $res;
        }	
    }

?>
