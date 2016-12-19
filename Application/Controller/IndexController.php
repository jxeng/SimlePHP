<?php
namespace Application\Controller;

use Smile\Controller;
use Smile\Factory;

class IndexController extends Controller
{
    public function indexAction()
    {
//        $test = Factory::getModel(__NAMESPACE__, 'test');
//        $res = $test->fetchAll();
//        $this->assign('res', $res);
        $this->assign('welcome', '欢迎使用！');
        $this->display();
    }
}