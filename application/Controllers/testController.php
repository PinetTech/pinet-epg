<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct 
script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid"})
 * @Clips\MessageBundle(name="welcome")
 */
class TestController extends BaseController
{
    private function navigation() {
        $nav1 = $this->action('/nav', 'label');
        $nav1->children = array(
            $this->action('/nav/1', 'nav1-1'),
            $this->action('/nav/2', 'nav1-2'), 
            $this->action('/nav/3', 'nav1-3')
        );
        $nav2 = $this->action('/nav', 'label');
        $nav2->children = array(
            $this->action('/nav/1', 'nav2-1'),
            $this->action('/nav/2', 'nav2-2'), 
            $this->action('/nav/3', 'nav2-3')
        );
        $nav3 = $this->action('/nav', 'label');
        $nav3->children = array(
            $this->action('/nav/1', 'nav3-1'),
            $this->action('/nav/2', 'nav3-2'), 
            $this->action('/nav/3', 'nav3-3')
        );
        $nav4 = $this->action('/nav', 'label');
        $nav4->children = array(
            $this->action('/nav/1', 'nav4-1'),
            $this->action('/nav/2', 'nav4-2'), 
            $this->action('/nav/3', 'nav4-3')
        );
        $nav5 = $this->action('/nav', 'label');
        $nav5->children = array(
            $this->action('/nav/1', 'nav5-1'),
            $this->action('/nav/2', 'nav5-2'), 
            $this->action('/nav/3', 'nav5-3')
        );
        $nav6 = $this->action('/nav', 'label');
        $nav6->children = array(
            $this->action('/nav/1', 'nav6-1'),
            $this->action('/nav/2', 'nav6-2'), 
            $this->action('/nav/3', 'nav6-3')
        );
        $nav7 = $this->action('/nav', 'label');
        $nav7->children = array(
            $this->action('/nav/1', 'nav7-1'),
            $this->action('/nav/2', 'nav7-2'), 
            $this->action('/nav/3', 'nav7-3')
        );        
        $nav8 = $this->action('/nav', 'label');
        $nav8->children = array(
            $this->action('/nav/1', 'nav8-1'),
            $this->action('/nav/2', 'nav8-2'), 
            $this->action('/nav/3', 'nav8-3')
        ); 
        return array(
            $nav1,
            $nav2,
            $nav3,
            $nav4,
            $nav5,
            $nav6,
            $nav7,
            $nav8
        );
    }

    /**
     * @Clips\Form({"search"})
     * @Clips\Model({"title","column","movie"})     
     * @Clips\Widget({"epg", "navigation", "image"})
     * @Clips\Scss({"welcome/index"})
     * @Clips\Js({"application/static/js/welcome/index.js"})
     */
    public function index() {
        $this->title('Pinet Home Page',true);               
        return $this->render('welcome/index', array(
            'actions'=>$this->navigation(),
            'items'=>array(
                (object)array('title'=>'nature1', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/1'),
                (object)array('title'=>'nature2', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/2'),
                (object)array('title'=>'nature3', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/3'),
                (object)array('title'=>'nature4', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/4'),
                (object)array('title'=>'nature5', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/5'),
                (object)array('title'=>'nature6', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/6'),
                (object)array('title'=>'nature7', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/7'),
                (object)array('title'=>'nature8', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/8'),
                (object)array('title'=>'nature9', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/9')
            ),
            "tab"=>array(
                "navs"=>array(
                    'nav1',
                    'nav2',
                    'nav3'
                ),
                "contents"=>array(
                    (object)array('title'=>'movie1','info'=>'sdsdsdsdsds'),
                    (object)array('episodes'=>'1,2,3,4,5'),
                    (object)array('number'=>array('sdsds','sdsds','sdsdsds'))
                )
            ),
            "videos"=>array(
                (object)array('title'=>'movie title1', 'count'=>'152万', 'imageSrc'=>\Clips\static_url('application/static/img/test/01.png')),
                (object)array('title'=>'movie title2', 'count'=>'152万', 'imageSrc'=>\Clips\static_url('application/static/img/test/01.png')),
                (object)array('title'=>'movie title3', 'count'=>'152万', 'imageSrc'=>\Clips\static_url('application/static/img/test/01.png')),
                (object)array('title'=>'movie title4', 'count'=>'152万', 'imageSrc'=>\Clips\static_url('application/static/img/test/01.png')),
                (object)array('title'=>'movie title5', 'count'=>'152万', 'imageSrc'=>\Clips\static_url('application/static/img/test/01.png')),
                (object)array('title'=>'movie title6', 'count'=>'152万', 'imageSrc'=>\Clips\static_url('application/static/img/test/01.png'))
            )
        ));
    }

    /**
     * @Clips\Form({"search"})
     * @Clips\Model({"title","column","movie"})     
     * @Clips\Widget({"epg", "navigation", "image"})
     * @Clips\Scss({"welcome/list"})
     * @Clips\Js({"application/static/js/welcome/list.js"})
     */
    public function movielist() {
        $nav1 = $this->action('/nav', 'label');
        $nav1->children = array(
            $this->action('/nav/1', 'nav1-1'),
            $this->action('/nav/2', 'nav1-2'), 
            $this->action('/nav/3', 'nav1-3'),
            $this->action('/nav/1', 'nav1-1'),
            $this->action('/nav/2', 'nav1-2'), 
            $this->action('/nav/3', 'nav1-3')
            
        );
        $nav2 = $this->action('/nav', 'label');
        $nav2->children = array(
            $this->action('/nav/1', 'nav2-1'),
            $this->action('/nav/2', 'nav2-2'), 
            $this->action('/nav/3', 'nav2-3')
        );
        $nav3 = $this->action('/nav', 'label');
        $nav3->children = array(
            $this->action('/nav/1', 'nav3-1'),
            $this->action('/nav/2', 'nav3-2'), 
            $this->action('/nav/3', 'nav3-3')
        );        
        return $this->render('welcome/list', array(
            "actions"=>array(
                $nav1,
                $nav2,
                $nav3
            ),
            "tab"=>array(
                "navs"=>array(
                    'nav1',
                    'nav2'
                ),
                "contents"=>array(
                    (object)array('title'=>'movie1','info'=>'sdsdsdsdsds'),
                    (object)array('episodes'=>'1,2,3,4,5'),
                    (object)array('number'=>array('sdsds','sdsds','sdsdsds'))
                )
            ),
            'items'=>array(
                (object)array('title'=>'nature1', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/1'),
                (object)array('title'=>'nature2', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/2'),
                (object)array('title'=>'nature3', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/3'),
                (object)array('title'=>'nature4', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/4'),
                (object)array('title'=>'nature5', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/5'),
                (object)array('title'=>'nature6', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/6'),
                (object)array('title'=>'nature7', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/7'),
                (object)array('title'=>'nature8', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/8'),
                (object)array('title'=>'nature9', 'res'=>'test/01.png', 'image'=>'http://lorempixel.com/1200/1200/nature/9')
            ),             
        ));
    }    

    /**
     * @Clips\Form({"search"})
     * @Clips\Model({"title","column","movie"})     
     * @Clips\Widget({"epg", "navigation", "image"})
     * @Clips\Scss({"search/movie_mobile"})
     * @Clips\Js({"application/static/js/welcome/search.js"})
     */
    public function search() {
        return $this->render("search/movie-mobile", array(
            'actions'=>$this->navigation(),
            "tab"=>array(
                    "navs"=>array(
                            'nav1',
                            'nav2',
                            'nav3',
                            'nav4',
                            'nav5'
                    ),
                    "contents"=>array(
                            (object)array('title'=>'movie1','info'=>'sdsdsdsdsds'),
                            (object)array('episodes'=>'1,2,3,4,5'),
                            (object)array('number'=>array('sdsds','sdsds','sdsdsds'))
                    )
            )            
        ));
    }

    /**
     * @Clips\Form({"search"})
     * @Clips\Model({"title","column","movie"})     
     * @Clips\Widget({"epg", "navigation", "image", "videoJs"})
     * @Clips\Scss({"welcome/play"})
     * @Clips\Js({"application/static/js/welcome/play.js"})
     */
    public function movieplay() {       
        return $this->render("welcome/play", array(
            'actions'=>$this->navigation(),
            "tab"=>array(
                "navs"=>array(
                    'nav1',
                    'nav2',
                    'nav3'
                ),
                "contents"=>array(
                    (object)array('title'=>'movie1','info'=>'sdsdsdsdsds'),
                    (object)array('episodes'=>'1,2,3,4,5'),
                    (object)array('number'=>array('sdsds','sdsds','sdsdsds'))
                )
            ) 
        ));
    }

    /**
     * @Clips\Form({"search"})
     * @Clips\Widget({"epg", "navigation", "image"})
     * @Clips\Scss({"error500"})
     */
    public function showerror() {
        return $this->render('error/500');
    }   

}
