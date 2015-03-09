<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
//    public function behaviors() {
//        return array(
//            // attach channel behavior
//            'channel' => array(
//                'class' => '\YiiNodeSocket\Behaviors\ArChannel',
//                'updateOnSave' => true
//            ),
//            // attach subscriber behavior
//            'subscriber' => array(
//                'class' => '\YiiNodeSocket\Behaviors\ArSubscriber'
//            )
//        );
//    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = User::findOne(["id"=>$id]);
        if($user)
        {
            return new static($user);
        }

      //  return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = User::findOne(["accessToken"=>$token]);
        if($user)
        {
            return new static($user);
        }
//        foreach (self::$users as $user) {
//            if ($user['accessToken'] === $token) {
//                   return new static($user);
//            }
//        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = User::findOne(["username"=>$username]);
        if($user)
        {
            return new static($user);
        }

//        foreach (self::$users as $user) {
//            if (strcasecmp($user['username'], $username) === 0) {
//                return new static($user);
//            }
//        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
