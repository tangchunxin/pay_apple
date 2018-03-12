<?php
namespace bigcat\model;

use bigcat\inc\ListFactory;
class PlayRechargeListFactory extends ListFactory
{
    public $key = 'big_agent_play_recharge_list_';
    public function __construct($dbobj, $aid = null, $id_multi_str='') 
    {
        //$id_multi_str 是用,分隔的字符串
        if($aid) 
        {
            $this->key = $this->key.$aid;
            $this->sql = "select `play_rid` from `play_recharge` where aid=".intval($aid)."";
            parent::__construct($dbobj, $this->key);
            return true;
        }
/*        elseif($aid == null && $id_multi_str == null) 
        {
            $this->key = $this->key.$aid;
            $this->sql = "select `play_rid` from `play_recharge` ";
            parent::__construct($dbobj, $this->key);
            return true;
        }*/
        elseif ($id_multi_str) 
        {
            $this->key = $this->key.md5($id_multi_str);
            parent::__construct($dbobj, $this->key, null, $id_multi_str);
            return true;
        }
        return false;
    }
}

