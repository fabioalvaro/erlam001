<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*define('db_host', 'localhost');
define('db_user', 'root');
define('db_pass', '');
define('db_base', 'erlan001');
define('dir_arquivos', 'arquivos_dos_alunos/');*/

define('db_host', 'mysql.fabioalvaro.com.br');
define('db_user', 'fabioalvaro10');
define('db_pass', 'xuxu2013');
define('db_base', 'fabioalvaro10');
define('dir_arquivos', 'arquivos_dos_alunos/');

function dateEnToPTbr($dateENFormat=''){
  $date = new DateTime($dateENFormat);
  $final = $date->format('d/m/Y');   
  return $final;
}

function datePTbrToEn($datePtBrFormat=''){
  $date = explode('/',$datePtBrFormat);
  $final = $date[2].'-'.$date[1].'-'.$date[0];  
  return $final;
}

?>
