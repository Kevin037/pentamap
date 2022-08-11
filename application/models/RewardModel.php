<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RewardModel extends CI_Model
{
    public function get_reward_perusahaan()
    {
        $query =
            "SELECT * FROM tb_reward 
            JOIN kabupaten ON tb_reward.kabupaten_kota = kabupaten.id_kabupaten 
            -- JOIN tb_perusahaan ON tb_reward.nama_perusahaan = tb_perusahaan.id
            JOIN jenis_sektor_usaha ON tb_reward.sektor_usaha = jenis_sektor_usaha.id_sektor
            ORDER BY tb_reward.id_reward  DESC
                ";
        return $this->db->query($query)->result_array();
    }

    public function get_tb_reward()
    {
        $query =
            "SELECT * FROM tb_reward 
            ORDER BY tb_reward.id_reward  ASC
                ";
        return $this->db->query($query)->result_array();
    }

    public function get_rewardById($id)
    {
        $query = "SELECT * FROM tb_reward WHERE tb_reward.id_reward = '$id'
                ";
        return $this->db->query($query)->row();
    }

}
