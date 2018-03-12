<?php
/**
 * @author xuqiang76@163.com
 * @final 20160929
 */

namespace bigcat\inc;

use bigcat\inc\Factory;
use bigcat\inc\BaseFunction;

class ListFactory extends Factory
{
	public $sql='';
	public $list_key;
	public $id_arr;

	public function __construct($dbobj, $key, $timeout = null, $id_multi_str = '' )
	{
		$this->list_key = $key;
		if($id_multi_str)
		{
			$this->id_arr = explode(',', $id_multi_str);
		}
		parent::__construct($dbobj, $this->list_key, $this->list_key, $timeout);
	}

	public function retrive()
	{
		$list_arr = array();
		$records = null;
		if($this->id_arr && is_array($this->id_arr))
		{
			return $this->id_arr;
		}
		else
		{
			if($this->sql)
			{
				$records = BaseFunction::query_sql_backend($this->sql);
			}

			if ( $records )
			{
				while ( ($row = $records->fetch_row()) != false )
				{
					$list_arr[] = $row[0];
				}
				$records->free();
				unset($records);
				return $list_arr;
			}
		}

		return $list_arr;
	}
}