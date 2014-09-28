<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ApplicationController
 *
 * @author Administrator
 */
class ApplicationController extends CController {
    
    protected function getRequest() {
        return json_decode(file_get_contents('php://input'), true);
    }
    
    public function response($code = 0, $msg = '', $data = '') {
        echo json_encode(array(
            'code' => $code,
            'msg' => $msg,
            'response' => $data
        ));
        Yii::app()->end();
    }
    
}
