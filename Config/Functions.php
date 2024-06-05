<?php
//Funciones que reutilizables

  //Da formato a la fecha
  function time_ago($fecha)
  {
      $diferencia = time() - $fecha;
      if ($diferencia < 1) {
          return 'Justo ahora';
      }
  
      $condicion = array(
          12 * 30 * 24 * 60 * 60 => array('singular' => 'año', 'plural' => 'años'),
          30 * 24 * 60 * 60 => array('singular' => 'mes', 'plural' => 'meses'),
          24 * 60 * 60 => array('singular' => 'día', 'plural' => 'días'),
          60 * 60 => array('singular' => 'hora', 'plural' => 'horas'),
          60 => array('singular' => 'min', 'plural' => 'mins'),
          1 => array('singular' => 'seg', 'plural' => 'segs')
      );
  
      foreach ($condicion as $secs => $str) {
          $d = $diferencia / $secs;
          if ($d >= 1) {
              // redondear
              $t = round($d);
              // seleccionar singular o plural
              $unidad = $t > 1 ? $str['plural'] : $str['singular'];
              return 'hace ' . $t . ' ' . $unidad;
          }
      }
  }
  
?>