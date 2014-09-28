<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class PublicController extends BaseController{
    public function actionError(){
        if($error = Yii::app()->errorHandler->error){
            echo '<pre>';
              print_r($error);
        }
    }
}
?>
