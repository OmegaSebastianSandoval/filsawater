<?php
define('DEFAULT_TITLE', 'Filsa Water');// titulo general para toda la pagina

$config = array(); //
// phpinfo(    );  
$config ['production']= array();
$config ['production']['db'] = array();
$config ['production']['db']['host'] ='localhost';
$config ['production']['db']['name'] ='';
$config ['production']['db']['user'] ='';
$config ['production']['db']['password'] ='';
$config ['production']['db']['port'] ='3306';
$config ['production']['db']['engine'] ='mysql';

$config ['production']['wompi']['redirectUrl'] ='https://checkout.wompi.com/';
$config ['production']['wompi']['publicKey'] ='pub_prod_Lh1vWGoHYx8oT7suLwWUu0NyIDgJma6g';
$config ['production']['wompi']['secretKey'] ='prv_prod_R2R3CtS5CdEgTrMXG8OQEP9JHssVu6AY';
$config ['production']['wompi']['events'] ='prod_events_3YS86pAEYDmukbjzzaQVkwYHr2Y0GElB';
$config ['production']['wompi']['integrity'] ='prod_integrity_gO4fTGFAz17TqfZqmoy7hiXn4Bgl9PN4';


$config ['staging']= array();
$config ['staging']['db'] = array();
$config ['staging']['db']['host'] ='localhost';
$config ['staging']['db']['name'] ='omegasol_xovis';
$config ['staging']['db']['user'] ='omegasol_xovis';
$config ['staging']['db']['password'] ='XovisOmega.2022';
$config ['staging']['db']['port'] ='3306';
$config ['staging']['db']['engine'] ='mysql';

$config ['staging']['wompi']['redirectUrl'] ='http://192.168.150.4:8043/page/comprar/respuesta';
$config ['staging']['wompi']['publicKey'] ='pub_test_IgJV5KZuyaM9JRr037F84I12pgvKJ1T9';
$config ['staging']['wompi']['secretKey'] ='prv_test_R6B0xdeGNxIpa3QIjTbu5X0GWDXewEmt';
$config ['staging']['wompi']['events'] ='test_events_beAT4yRfN6I8PcOxXgwEMhIfbUh2Kcqv';
$config ['staging']['wompi']['integrity'] ='test_integrity_xqdlZhUvBkjhnD6X1NsMg3ymppqF5HUV';



$config ['development']= array();
$config ['development']['db'] = array();
$config ['development']['db']['host'] ='localhost';
$config ['development']['db']['name'] ='filsa_water';
$config ['development']['db']['user'] ='root';
$config ['development']['db']['password'] = '';
$config ['development']['db']['port'] ='3306';
$config ['development']['db']['engine'] ='mysql';

$config ['development']['wompi']['redirectUrl'] ='http://192.168.150.4:8043/page/comprar/respuesta';
$config ['development']['wompi']['publicKey'] ='pub_test_IgJV5KZuyaM9JRr037F84I12pgvKJ1T9';
$config ['development']['wompi']['secretKey'] ='prv_test_R6B0xdeGNxIpa3QIjTbu5X0GWDXewEmt';
$config ['development']['wompi']['events'] ='test_events_beAT4yRfN6I8PcOxXgwEMhIfbUh2Kcqv';
$config ['development']['wompi']['integrity'] ='test_integrity_xqdlZhUvBkjhnD6X1NsMg3ymppqF5HUV';


