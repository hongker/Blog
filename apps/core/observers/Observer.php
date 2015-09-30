<?php
namespace Blog\Observers;
/**
 * 观察者接口
 * @author hongker
 * @version 1.0
 */
interface Observer {
	/**
	 * 信息变更
	 */
	public function update();
}