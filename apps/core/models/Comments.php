<?php
namespace Blog\Models;
/**
 * Comments模型
 * @author hongker
 * @version 1.0
 */
class Comments extends BaseModel {
	protected $type;
	/**
	 * 模型初始化
	 */
	public function initialize() {
		parent::initialize();
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
         ));
		
		//关联articles表
		$this->belongsTo("target_id", "Blog\Models\Articles", "id", array(
				'alias' => 'Article'
		));
		
		
		$this->hasMany("id", "Blog\Models\Replies", "comment_id", array(
				'alias' => 'Replies'
		));
	}
	
	/**
	 * 验证字段是否合法
	 * @return boolean
	 */
	public function validation() {
		$validates = array();
		$validates[] = $this->setPresenceOf('author_id', 1203);
		$validates[] = $this->setPresenceOf('target_id', 1204);
		$validates[] = $this->setPresenceOf('content', 1205);
	
		if($this->validateAll($validates)==false) {
			return false;
		}
	
	}
}