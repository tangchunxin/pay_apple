<?php
namespace bigcat\model;

use bigcat\inc\MutiStoreFactory;
use bigcat\inc\BaseFunction;
class PlayRechargeMultiFactory extends MutiStoreFactory
{
    public $key = 'big_agent_play_recharge_multi_';
    private $sql;

    public function __construct($dbobj, $key_objfactory=null, $play_rid=null, $key_add='') 
    {
        if( !$key_objfactory && !$play_rid )
        {
            return false;
        }
        $this->key = $this->key.$key_add;
        $ids = '';
        if($key_objfactory) 
        {
            if($key_objfactory->initialize()) 
            {
                $key_obj = $key_objfactory->get();
                $ids = implode(',', $key_obj);
            }
        }
        $fields = "
            `play_rid`
            , `play_id`
            , `play_name`
            , `last_amount`
            , `recharge_amount`

            , `play_sum_amount`
            , `aid`
            , `recharge_time`
            ";

        if( $play_rid != null )
        {
            $this->bInitMuti = false;
            $this->sql = "select $fields from play_recharge where `play_rid`=".intval($play_rid)."";
        }
        else
        {
            $this->sql = "select $fields from play_recharge ";
            if($ids)
            {
                $this->sql = $this->sql." where `play_rid` in ($ids) ";
            }
        }
        parent::__construct($dbobj, $this->key, $this->key, $key_objfactory, $play_rid);
        return true;
    }

    public function retrive() 
    {
        $records = BaseFunction::query_sql_backend($this->sql);
        if( !$records ) 
        {
            return null;
        }

        $objs = array();
        while ( ($row = $records->fetch_row()) != false ) 
        {
            $obj = new PlayRecharge;

            $obj->play_rid = intval($row[0]);
            $obj->play_id = intval($row[1]);
            $obj->play_name = ($row[2]);
            $obj->last_amount = intval($row[3]);
            $obj->recharge_amount = intval($row[4]);

            $obj->play_sum_amount = intval($row[5]);
            $obj->aid = intval($row[6]);
            $obj->recharge_time = intval($row[7]);

            $obj->before_writeback();
            $objs[$this->key.'_'.$obj->play_rid] = $obj;
        }
        $records->free();
        unset($records);
        return $objs;
    }
}


