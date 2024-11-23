<?php

final class Payment_Wompi
{
    protected $_data = null;
    private static $_instance = null;
    protected $wompi;
    protected $resClient;

    private function __construct()
    {
        $data = array();
        $data['redirectUrl'] = Config_Config::getInstance()->getValue('wompi/redirectUrl');
        $data['publicKey'] = Config_Config::getInstance()->getValue('wompi/publicKey');
        $data['secretKey'] = Config_Config::getInstance()->getValue('wompi/secretKey');
        $data['events'] = Config_Config::getInstance()->getValue('wompi/events');
        $data['integrity'] = Config_Config::getInstance()->getValue('wompi/integrity');

        $this->_data = $data;

        $this->wompi = [
            'redirectUrl' => $this->_data['redirectUrl'],
            'publicKey' => $this->_data['publicKey'],
            'secretKey' => $this->_data['secretKey'],
            'events' => $this->_data['events'],
            'integrity' => $this->_data['integrity'],
        ];
    }

    public function getWompi()
    {
        return  $this->wompi;
    }

    public function getData()
    {

        return $this->_data;
    }

    public static function getInstance()
    {
        if (null == self::$_instance) {
            self::$_instance = new Payment_Wompi();
        }
        return self::$_instance;
    }
}
