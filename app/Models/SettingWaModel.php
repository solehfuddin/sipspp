<?php 
namespace App\Models;
use CodeIgniter\Model;

class SettingWaModel extends Model {
    protected $table = 'wa_config';
    protected $primaryKey = 'id';
    protected $allowedFields = ['token', 'instance_id'];
}