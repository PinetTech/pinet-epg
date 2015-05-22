<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "bootstrap"})
 * @Clips\MessageBundle(name="welcome")
 */
class WelcomeController extends BaseController
{
    public function index() {
        $this->title('Pinet Home Page',true);
		echo '<center>Hello EPG</center>';
    }

    /**
     * @Clips\Widget({"epg"})
     * @Clips\Scss({"welcome/index"})
     * @Clips\Js({"application/static/js/welcome/index.js"})
     */
    public function test() {
        $this->title('Pinet Home Page',true);
        return $this->render('welcome/index', array(
            'items'=>array(
                (object)array('title'=>'nature1', 'image'=>'http://lorempixel.com/1200/1200/nature/1'),
                (object)array('title'=>'nature2', 'image'=>'http://lorempixel.com/1200/1200/nature/2'),
                (object)array('title'=>'nature3', 'image'=>'http://lorempixel.com/1200/1200/nature/3'),
                (object)array('title'=>'nature4', 'image'=>'http://lorempixel.com/1200/1200/nature/4'),
                (object)array('title'=>'nature5', 'image'=>'http://lorempixel.com/1200/1200/nature/5'),
            ) 
        ));
    }
}
