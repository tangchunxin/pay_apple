<?php
namespace bigcat\model;

use bigcat\inc\BaseObject;
use bigcat\inc\BaseFunction;
class PlayRecharge extends BaseObject
{
    const TABLE_NAME = 'play_recharge';

    public $play_rid;	//自增长id

    public $play_id = 0;	//玩家id

    public $play_name = '';	//玩家昵称 
    public $last_amount = 0;	//玩家剩余钻数
    public $recharge_amount = 0;	//玩家充值钻数

    public $play_sum_amount = 0;	//充值后钻数量
    public $aid = 0;	//充钻的代理ID
    public $recharge_time = 0;	//充值时间

    public function getUpdateSql() 
    {
        return "update `play_recharge` SET
            `play_id`=".intval($this->play_id)."
            , `play_name`='".BaseFunction::my_addslashes($this->play_name)."'
            , `last_amount`=".intval($this->last_amount)."
            , `recharge_amount`=".intval($this->recharge_amount)."

            , `play_sum_amount`=".intval($this->play_sum_amount)."
            , `aid`=".intval($this->aid)."
            , `recharge_time`=".intval($this->recharge_time)."

            where `play_rid`=".intval($this->play_rid)."";
    }

    public function getInsertSql() 
    {
        return "insert into `play_recharge` SET

            `play_id`=".intval($this->play_id)."
            , `play_name`='".BaseFunction::my_addslashes($this->play_name)."'
            , `last_amount`=".intval($this->last_amount)."
            , `recharge_amount`=".intval($this->recharge_amount)."

            , `play_sum_amount`=".intval($this->play_sum_amount)."
            , `aid`=".intval($this->aid)."
            , `recharge_time`=".intval($this->recharge_time)."
            ";
    }

    public function getDelSql() 
    {
        return "delete from `play_recharge`
            where `play_rid`=".intval($this->play_rid)."";
    }

    public function before_writeback() 
    {
        parent::before_writeback();
        return true;
    }

}

