<?php
namespace Blog\Models;
/**
 * Comments模型
 * @author hongker
 *
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
		if($this->type==1) {
			//关联articles表
			$this->belongsTo("target", "Blog\Models\Articles", "id", array(
					'alias' => 'Article'
			));
		}
		
		
		$this->hasMany("id", "Blog\Models\Replies", "comment_id", array(
				'alias' => 'Replies'
		));
	}
}