<?php
namespace Blog\Utils;
/**
 * 验证码工具类
 * @author hongker
 * @version 1.0
 */
class Code {
	private $code;
	private $count; //位数
	private $type; //类型:1(全数字),2(数字+字母)
	
	/**
	 * 生成验证码
	 * @param number $count 验证码位数，默认为4
	 * @param number $type 验证码类型：1(全数字),2(数字+字母),默认为2
	 */
	public function __construct($count=4,$type=2) {
		$this->count = $count;
		$this->type = $type;
		$this->create();
	}
	
	/**
	 * 生成验证码
	 */
	private function create() {
		if($this->type==1) {
			$string = '0123456789';
		}else {
			$string = "abcdefghijklmnopqrstuvwxyz0123456789";
		}
		
		$str = "";
		for($i=0;$i<$this->count;$i++){
			$pos = rand(0,35);
			$str .= $string{$pos};
		}
		$this->code = $str;
		$this->store();
	}
	
	/**
	 * 保存验证码到session
	 */
	private function store() {
		session_start();
		$_SESSION['code'] = $this->code;
	}
	
	/**
	 * 获取验证码
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}
}
