<?php
namespace Blog\Operations;
use Blog\Models\Articles;
use Blog\Models\Users;
use Blog\Components\DateComponent;
/**
 * 文章操作类
 * @author hongker
 * @version 1.0
 */
class ArticleOperation extends BaseOperation implements Operation {
	public function __construct($di) {
		parent::__construct($di);
		$this->setLogFile('article.log');
	}
	
	/**
	 * 根据文章id获取文章信息
	 * @param int $id
	 * @return Users 返回文章
	 */
	public function get($id) {
		$article = Articles::findFirst($id);
		
		return $article;
	}
	
	/**
	 * 添加阅读量
	 * @param int $id
	 */
	public function addView($id) {
		$key = 'article_view';
		$this->addTodayView($id);
		return $this->redis->zIncrBy($key,1,"article:$id");
	}
	
	/**
	 * 根据天数保存阅读量，以备统计之用
	 * @param int $id
	 */
	public function addTodayView($id) {
		$key = 'article_view:'.date('Ymd');
		$this->redis->zIncrBy($key,1,"article:$id");
	}
	
	/**
	 * 添加文章
	 * @param array $data
	 * @return array
	 */
	public function save(Array $data) {
		if(empty($data['title'])) {
			$return['errNo'] = 1102;
			return $return;
		}
		
		if(empty($data['picture'])) {
			$data['picture'] = '/images/article/article_'.rand(1, 5).'.jpg';
		}
		
		
		if(empty($data['digest'])) {
			$return['errNo'] = 1103;
			return $return;
		}
		
		if(empty($data['type_id'])) {
			$return['errNo'] = 1104;
			return $return;
		}
		
		if(empty($data['class'])) {
			$return['errNo'] = 1115;
			return $return;
		}
		
		
		$article = new Articles();
		foreach ($data as $key=>$value) {
			$article->$key = $value;
		}
	
		if($article->save()==true) {
			$return['errNo'] = 0;
			$logString = $this->getLogString('添加文章', 0);
			$this->log($logString, 'info');
		}else {
			$return['errNo'] = 1015;
			foreach ($article->getMessages() as $message) {
				$logString = $this->getLogString('添加文章', $message);
				$return['errNo'] = $message;
				$this->log($logString,'error');
			}
		}
		return $return;
	}
	
	/**
	 * 根据文章id更改文章信息
	 * @param unknown $id
	 * @param array $array
	 * @return 成功返回true,失败返回false
	 */
	public function update($id,array $array) {
		$article = $this->get($id);
		if($article) {
			foreach ($array as $key=>$value) {
				$article->$key = $value;
			}
			
			if($article->update()) {
				$return['errNo'] = 0;
			}else {
				$return['errNo'] = 1020;
			}
		}else {
			$return['errNo'] = 1110;
		}
		
		return $return;
	}
	
	/**
	 * 通过审核
	 * @param int $id
	 * @return array
	 */
	public function check($id) {
		$article = $this->get($id);
		
		if($article) {
			if($article->status==1) {
				$return['errNo'] = 1111;
			}else {
				$article->status = 1;
				if($article->update()) {
					$return['errNo'] = 0;
				}else {
					$return['errNo'] = 1112;
				}
			}
		}else {
			$return['errNo'] = 1110;
		}
		return $return;
	}
	
	/**
	 * 驳回审核
	 * @param int $id
	 * @return array
	 */
	public function  reject($id) {
		$article = $this->get($id);
	
		if($article) {
			if($article->status==0) {
				$return['errNo'] = 1113;
			}else {
				$article->status = 0;
				if($article->update()) {
					$return['errNo'] = 0;
				}else {
					$return['errNo'] = 1114;
				}
			}
		}else {
			$return['errNo'] = 1110;
		}
		return $return;
	}
	
	/**
	 * 根据文章id删除文章信息
	 * @param int $id
	 * @return 成功返回true,失败返回false
	 */
	public function delete($id) {
		$article = $this->get($id);
		
		if ($article != false) {
			if ($article->delete() != false) {
				$logString = $this->getLogString('删除文章');
				$this->log($logString, 'info');
				return true;
			}
		}
		return false;
	}
	
	/**
	 * 根据文章id获取作者信息
	 * @param unknown $id
	 * 
	 */
	public function getAuthor($id) {
		$article =$this->get($id);
		return $article->getAuthor();
	}
	
	/**
	 * 根据条件查找文章数据
	 * @param string $condition
	 */
	public function findAll(Array $condition = null) {
		return Articles::find($condition);
	}
	
	/**
	 * 根据类型获取文章
	 * @param unknown $type
	 */
	public function classify($type) {
		return $this->findAll(array(
				"conditions"=>"type_id=$type and status=1 and is_delete=0",
				"order"=>"created_at desc",
		));
	}
	
	/**
	 * 判断用户是否为文章作者
	 * @param int $id 文章id
	 * @param int $user_id 用户id
	 * @return boolean
	 */
	public function checkIsAuthor($id,$user_id) {
		$article = $this->get($id);
		
		if($article&&$article->author_id==$user_id) {
			return true;
		}
		return false;
		
	}
	
	/**
	 * 获取推荐文章
	 * @param unknown $id
	 * @param number $count
	 * @return Ambigous <number, unknown>
	 */
	public function getRecommends($id,$count = 5) {
		$article = $this->get($id);
		
		if($article) {
			$articles = $this->findAll(array(
				'conditions'=>"is_delete=0 and type_id={$article->type_id} and id !={$id}",
				'limit'=>$count,
			));
			$return['errNo'] = 0;
			$return['articles'] = $articles;
		}else {
			$return['errNo'] = 1110;
		}
		return $return;
	}
	
	/**
	 * 根据文章发布数量获取用户
	 * @param number $limit
	 * @return multitype:unknown
	 */
	public function getUsersByCount($limit = 5) {
		$articles = Articles::count(array(
			'conditions' => 'is_delete=0',
			'group' => 'author_id',
			'order' => 'rowcount desc',
			'columns' => 'author_id',
			'limit' => $limit,
		));
		
		$users = array();
		foreach ($articles as $article) {
			
			$user = Users::findFirst($article->author_id);
			if($user) {
				$users[] = $user;
			}
		}
		
		return $users;
	}
	
	/**
	 * 获取阅读榜
	 * @param string $type
	 * @param number $limit
	 * @return multitype:\Blog\Models\Users
	 */
	public function getArticesRank($type = 'day', $limit = 5) {
		$articles = array();
		if($type=='day') {
			//获取日榜
			$key = 'article_view:'.date('Ymd');
			$result = $this->redis->zrevrange($key,0,$limit);
			
			foreach ($result as $value) {
				$article_id = explode(':', $value)[1];
				$article = $this->get($article_id);
				if($article) {
					$articles[] = $article;
				}
			}
		}elseif($type=='week') {
			//获取周榜
		}elseif($type=='month') {
			//获取月榜
		}elseif($type=='year') {
			//获取年榜
		}
		
		return $articles;
	}
	
	/**
	 * 获取某一天的点击排名
	 * @param date $date (格式: 20151005)
	 * @param int $start 开始下标
	 * @param int $stop 结束下标
	 * @return array
	 */
	private function getOneDayRankings($date, $start=0, $stop=5) {
		$articles = array();
		$key = 'article_view:'.$date;
		$result = $this->redis->zrevrange($key,$start,$stop);
		foreach ($result as $value) {
			$article_id = explode(':', $value)[1];
			$article = $this->get($article_id);
			if($article) {
				$articles[] = $article;
			}
		}
		return $articles;
	}
	
	/**
	 * 获取某段时间内的点击量排行
	 * @param array $dates 日期数组(格式：('20151001','20151002'))
	 * @param string $outKey 临时生成的key
	 * @param int $start
	 * @param int $stop
	 * @return array
	 */
	private function getMultiDaysRankings($dates, $outKey, $start=0, $stop=5) {
		$articles = array();
		
		$keys = array_map(function($date) {
			return 'article_view:'.$date;
		}, $dates);
		
		//权重因子
		$weights = array_fill(0, count($keys), 1);
		
		//生成集合
		$this->redis->zUnion($outKey, $keys, $weights);
		$result = $this->redis->zRevRange($outKey, $start, $stop);
		
		foreach ($result as $value) {
			$article_id = explode(':', $value)[1];
			
			$article = $this->get($article_id);
			if($article) {
				$articles[] = $article;
			}
		}
		
		return $articles;
	}
	
	/**
	 * 获取今日点击排行榜
	 * @param int $limit
	 * @return array
	 */
	public function getTodayRanks($limit = 5) {
		$date = date('Ymd');
		
		$articles = $this->getOneDayRankings($date,0,$limit);
		
		return $articles;
	}
	
	/**
	 * 获取本周点击排行
	 * @param number $limit
	 * @return array
	 */
	public function getWeekRanks($limit = 5) {
		$daysOfCurrentWeek = DateComponent::getDaysOfCurrentWeek();
		
		$articles = $this->getMultiDaysRankings($daysOfCurrentWeek, 'rank:current_week',0,$limit);
		
		return $articles;
	}
}