<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/24
 * Time: 2:55 PM
 */

namespace Tien\ThinkValidate;


use Tien\ThinkSwagger\exceptions\Exception;

trait Extra
{
    /**
     * :获取验证类
     *
     * @throws Exception
     */
    protected function getValidateClass()
    {
        if ($this->validateClass) {
            return;
        }
        $this->validateClass = 'app\\' . $this->request->module() . '\\validate\\' . $this->request->controller();
        if (!class_exists($this->validateClass)) {
            throw new Exception('验证类不存在：' . $this->validateClass);
        }
    }

    /**
     * :
     *
     */
    protected function getValidateObj()
    {
        $class = $this->validateClass;
        $this->validateObj = new $class();
    }


    /**
     * :
     *
     */
    protected function getAction()
    {
        if (!$this->action) {
            $this->action = $this->request->action(true);
        }
    }

    /**
     * :
     *
     */
    protected function getParam()
    {
        $this->param = $this->request->param(true);
    }



}