<?php
try{
    $pdo= new PDO('mysql:host=localhost;dbname=food_ordering_system','root','');

}
catch(PDPException $f){

echo $f->getmessage();

}











?>