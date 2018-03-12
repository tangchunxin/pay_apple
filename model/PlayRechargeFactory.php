<?php
namespace bigcat\model;

use bigcat\inc\Factory;
use bigcat\inc\BaseFunction;
class PlayRechargeFactory extends Factory
{
    const objkey = 'big_agent_play_recharge_multi_';
    private $sql;
    public function __construct($dbobj, $play_rid) 
    {
        $serverkey = self::objkey;
        $objkey = self::objkey."_".$play_rid;
        $this->sql = "select
            `play_rid`
            , `play_id`
            , `play_name`
            , `last_amount`
            , `recharge_amount`

            , `play_sum_amount`
            , `aid`
            , `recharge_time`

            from `play_recharge`
            where `play_rid`=".intval($play_rid)."";

        parent::__construct($dbobj, $serverkey, $objkey);
        return true;
    }

    public function retrive() 
    {
        $records = BaseFunction::query_sql_backend($this->sql);
        if( !$records ) 
        {
            return null;
        }

        $obj = null;
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
            break;
        }
        $records->free();
        unset($records);
        return $obj;
    }
}

