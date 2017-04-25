<?php
namespace backend\web\util;
use Yii;
class MyMail
{
   public static  function sendMail($msg,$subject)
   {
       $message = Yii::$app->mailer->compose();
       $message->setFrom('backend');
       $message->setTo(Yii::$app->params['adminEmail'])
           ->setSubject($subject)
           ->setTextBody($msg)
           ->send();
   }
}