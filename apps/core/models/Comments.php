<?php
namespace Blog\Models;
/**
 * Comments模型
 * @author hongker
 *
 */
class Comments extends BaseModel {
	/**
	 * 模型初始化
	 */
	public function initialize() {
		//关联users表
		$this->belongsTo("author_id", "Blog\Models\Users", "id", array(
              'alias' => 'Author'
         ));
		
		//关联articles表
		$this->belongsTo("article_id", "Blog\Models\Articles", "id", array(
				'alias' => 'Article'
		));
		
		$this->hasMany("id", "Blog\Models\Replies", "comment_id", array(
				'alias' => 'Replies'
		));
	}
}