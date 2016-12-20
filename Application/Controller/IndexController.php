<?php
namespace Application\Controller;

use Smile\Controller;
use Smile\Factory;

class IndexController extends Controller
{
    public function indexAction()
    {
//        $this->toUrl('login');
//        $this->assign('welcome', '欢迎使用！');
        $this->display();
    }
    public function loginAction()
    {
//        $test = Factory::getModel(__NAMESPACE__, 'test');
//        $res = $test->fetchAll();
//        $this->assign('res', $res);
        $this->display();
    }
}