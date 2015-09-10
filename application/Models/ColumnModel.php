<?php
namespace Pinet\EPG\Models;in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Libraries\DBModel;
use Clips\SimpleAction;
use Pinet\EPG\Core\FilterAction;

/**
 * The model for connecting to the column data in mms
 *
 * @author Jack
 * @version 1.0
 * @date Sat Aug 29 15:57:57 2015
 *
 * @Clips\Library("sling")
 * @Clips\Model({"movie"})
 */
class ColumnModel extends DBModel {

	public function getCategory(){
		return array(
			'all'=>'全部','剧情'=>'剧情', '动作'=>'动作', '犯罪'=>'犯罪', ''=>'喜剧', '喜剧'=>'科幻', '西部'=>'西部', '传记'=>'传记', '爱情'=>'爱情', '歌舞'=>'歌舞'
		, '惊悚'=>'惊悚', '冒险'=>'冒险', '悬疑'=>'悬疑', '奇幻'=>'奇幻', '历史'=>'历史', '恐怖'=>'恐怖', '战争'=>'战争', '运动'=>'运动', '音乐'=>'音乐', '家庭'=>'家庭'
		);
	}

	public function getArea(){
		return array(
			'all'=>'全部','中国大陆'=>'中国大陆', '香港'=>'香港', '英国'=>'英国', '美国'=>'美国', '德国'=>'德国', '法国'=>'法国', '澳大利亚'=>'澳大利亚', '台湾'=>'台湾', '丹麦'=>'丹麦', '日本'=>'日本'
		, '新西兰'=>'新西兰', '意大利'=>'意大利', '加拿大'=>'加拿大', '巴西'=>'巴西', '秘鲁'=>'秘鲁', '韩国'=>'韩国', '西班牙'=>'西班牙', '瑞士'=>'瑞士', '尼泊尔'=>'尼泊尔'
		);
	}

    public function getTime() {
        $ret = array('all' => '全部');

        for($i = 2015; $i > 2000; $i--) {
            $ret[$i] = $i;
        }
        return $ret;
    }

    public function getTypeNav($col = 'movie') {

        $ret = array();

        foreach(array('category' => '类别', 'area' => '区域', 'time' => '时间') as $a => $label) {
            $children = array();

            foreach($this->{'get'.ucfirst($a)}() as $k => $v) {
                $action = new FilterAction();
                $action->type = 'server';
                $action->label = $v;
				$action->mode = $a;
				$action->mode_value = $k;
                $action->content = '/column/show/movie/'.$a.'/'.$k;
                $children []= $action;
            }

            $col = new SimpleAction(array(
                'label' => $label,
                'children' => $children
            ));

            $ret []= $col;
        }

        return $ret;
    }

    public function getFrontPageColumns() {
        $cols = $this->getAllColumns();
        $result = array();

        foreach($cols as $col) {
            $col->url = \Clips\site_url('/column/show/'.$col->name);
            $col->videos = $this->getMovies($col->name);
            $result []= $col;
        }
		return $result;
    }

	public function getAllColumns(){
		$data = $this->sling->data('/epg/columns.1');
		$result = array();
		foreach($data as $k => $v) {
			if(is_object($v) && isset($v->type) && $v->type == 'column') {
				$result []= $v;
			}
		}
		return $result;
	}

    public function getNav() {
        $request = \Clips\context('request');
        if($request)
            $all_movies=$request->session('all_movies');
        $arr=array();
        foreach($all_movies as $k=>$v){
            $arr[$k]['name']=$all_movies[$k]->title;
            $arr[$k]['label']=$all_movies[$k]->title;
            $arr[$k]['content']='/movie/play/'.$all_movies[$k]->id;
        }
        $args=array();
        $serial_movies=$request->session('serial_movies');
        foreach($serial_movies as $k=>$v){
            $args[$k]['name']=$serial_movies[$k]->title;
            $args[$k]['label']=$serial_movies[$k]->title;
            $args[$k]['content']='/movie/play/'.$serial_movies[$k]->id;
        }
        $ser=array($arr,$args);
        $actions = array();
        foreach($this->getAllColumns() as $k=> $item) {
            $item->type = 'server';
            $item->content = '/column/show/'.$item->name;
            $item->children = $ser[$k];
            $action = new \Pinet\EPG\Core\ColumnAction($item);
            $actions []= $action;
        }
        return $actions;
    }


    /**
     * Get all the movies of this column
     */
    public function getMovies($col, $offset = 0, $limit = 10) {
        $data = $this->sling->data('/epg/columns/'.$col.'.1');
		$result = array();
        $i = 0;
		foreach($data as $k => $v) {
            if($i < $offset) {
                continue;
            }

            if($i >= $offset + $limit) {
                break;
            }

			if(is_object($v) && isset($v->id)) {
                $video = $this->sling->data('/media/video/'.$v->id);

                $mss = \Clips\config('mss_url');
                $mss = $mss[0];
                $video->poster_normal = $v->id.'/'.$video->poster_normal;
                $video->poster_small = $v->id.'/'.$video->poster_small;
				$result []= $video;
                $i++;
			}
		}
        return $result;
    }

    /**
     * Get the navigation actions for frontpage, take about 10 movie of each column
     */
    public function getNavigations() {
        $actions = array();
        foreach($this->getAllColumns() as $col) {
        }
    }

	public function getColumnByName($name){
		$cols = $this->getAllColumns();
		foreach($cols as $col) {
			if($col->name == $name)
				return $col;
		}
		return null;
	}

	public function getColumns($navs){
		$columns = array();
		foreach ($navs as $k=>$nav) {
			$videos = array();
			$movies = $this->video->getTitlesByColumn($nav->column_id,6);
			foreach ($movies as $movie) {
				$videos[]=(object)array('id'=>$movie->id, 'title'=>$movie->asset_name, 'count'=>$movie->record, 'imageSrc'=>$movie->sourceurl);
			}
			$columns[$k]['videos'] = $videos;
			$columns[$k]['column_id'] = $nav->id;
			$columns[$k]['column_name'] = $nav->column_name;
			$columns[$k]['url'] = 'movie/index/'.$nav->id;
		}
		return $columns;
	}

	public function getColumnMovieCount($movies){
		$columns = $this->getAllColumns();
		$counts = array();
		$movies = array_reduce($movies, function($carry, $movie){
			if(!isset($carry[$movie->column_id])) {
				$carry[$movie->column_id] = 0;
			}
			$carry[$movie->column_id]++;
			return $carry;
		}, $counts);
		foreach($columns as $column){
			if(isset($movies[$column->id])){
				$movies[$column->id] = array('id'=>$column->id, 'name'=> $column->column_name, 'count'=> $movies[$column->id]);
			}
		}
		ksort($movies);
		return $movies;
	}

}
