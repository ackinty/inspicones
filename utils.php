<?php

include_once('../inspicones.conf') ;
include_once('../vendor/autoload.php');

define('DEBUG', true) ;

function ajax_debug($var, $text="") {
      if (DEBUG) {
        $file = "/tmp/log.txt" ;
        $h = fopen($file, 'a') ;
        if (is_array($var)) {
          fputs($h, date('d/m/Y H:i:s').' array '.$text."\n") ;
          foreach($var as $key => $val) {
            fputs($h, '    ['.$key.'] => :'.$val.":\n") ;
          }
        }
        else {
          fputs($h, date('d/m/Y H:i:s').' '.$text. ' :'.$var.":\n") ;
        }
        fclose($h) ;
      }
}

////////////////////////////////////////////////////////////////////////////////
// Display variables, for debug
// sort of mix of print_r and var_dump...
// $var mixed variable to display
// $msg string a message to display
// $lvl int nothing to worry, used to indent display correctly, if unsure put 0 (zero)
// $border bool set it "true" if you want a nicer display
////////////////////////////////////////////////////////////////////////////////
function debug($var, $msg="", $lvl=0, $border=false) {
    $tabul = str_repeat("&nbsp;&nbsp;", $lvl) ; ;

    if ($border) {
        echo '<div style="background-color:#d99;text-align:left;margin:5px;padding:5px;color:black;border:3px solid red;">' ;
    }

    if (is_array($var)) {
        echo $tabul."$msg (array)<br />\n" ;
        foreach($var as $key => $val) {
            debug($val, "[$key]", $lvl+1) ;
        }
    }
    elseif(is_object($var)) {
        $array = array() ;
        $array = (array)$var ;
        echo $tabul ."$msg (object ". get_class($var) .") <br/>\n" ;
        debug($array, "", $lvl+1) ;
    }
    elseif(is_bool($var)) {
        $boolean2string = ($var)?"TRUE":"FALSE" ;
        echo $tabul .$msg ." (boolean):". $boolean2string .":<br/>\n" ;
    }
    else {
        echo $tabul ."$msg (". gettype($var) ."):$var:<br />\n" ;
    }

    if ($border) {
        echo "</div>" ;
    }
}

function getDateFromMysqlDatetime($mysqlDatetime) {
    list($date, $time) = explode(' ', $mysqlDatetime) ;
    return $date ;
}

function isAndroid() {
    return stristr($_SERVER['HTTP_USER_AGENT'],'android') ;
}

/**
 * store the query url (to be able to "header location" to it later)
 */
function storeUrlInCookie($url='') {
    if ($url == '') return;
    setcookie('request', $url, 0, WEB_APP);
}