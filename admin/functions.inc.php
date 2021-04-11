<?php
function pr(array $arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}
function prx(mixed $arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
    exit;
}
function get_safe_value($str){
    global $con;
    if($str <> ""){ // if($str != "")
        $str = trim($str);
        return mysqli_real_escape_string($con,$str);
    }

}
?>