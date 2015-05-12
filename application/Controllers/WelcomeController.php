<?php namespace Pinet\EPG\Controllers; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Pinet\EPG\Core\BaseController;

/**
 * @Clips\Widget({"html", "lang", "grid", "bootstrap"})
 * @Clips\MessageBundle(name="welcome")
 */
class WelcomeController extends BaseController
{
    /**
     * @Clips\Scss({"welcome/index"})
     */
    public function index() {
        $this->title('Pinet Home Page',true);
		echo '<center>Hello EPG</center>';
        return $this->render('welcome/index');
    }
}
