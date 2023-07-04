<?php

namespace App\Models;

use CodeIgniter\Model;

class M_admin_notification extends Model
{
    protected $table = 'admin_notification';

    public function getNotification($notification_id = '')
    {
        $builder = $this->db->table($this->table);
        if ($notification_id  != '') {
            $builder->where(['notification_id' => $notification_id]);
        }

        return $builder->get();
    }

    public function insertNotification($data)
    {
        $save = $this->db->table($this->table)->insert($data);
        return $save;
    }



    public function deleteNotification($notification_id)
    {
        $delete = $this->db->table($this->table)->where('notification_id', $notification_id)->delete();
        return $delete;
    }
}
