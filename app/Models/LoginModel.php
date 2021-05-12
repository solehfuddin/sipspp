<?php namespace App\Models;
use CodeIgniter\Model;

class LoginModel extends Model {
    protected $table = 'tb_user';

    public function login($mail){
        return $this->join('master_level', 'tb_user.id_level = master_level.id_level', 'left')
                    ->where(['tb_user.email' => $mail])
                    ->orWhere(['tb_user.username' => $mail])
                    ->find();
    }

    public function loginbyuserid($id){
        return $this->join('master_level', 'tb_user.id_level = master_level.id_level', 'left')
                    ->where(['tb_user.id_user' => $id])
                    ->find();
    }
}