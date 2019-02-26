<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/25
 * Time: 9:57 PM
 */

namespace Tien\ThinkValidate;


use Tien\ThinkSwagger\exceptions\Exception;
use Tien\ThinkValidate\exceptions\TypeStringException;

class Validate
{
    use Extra;

    /**
     * @var string
     */
    protected $validateClass = '';

    /**
     * @var string
     */
    protected $validateObj = '';

    /**
     * @var string
     */
    protected $action;


    protected $request;

    /**
     * 操作数据
     *
     * @var array
     */
    protected $param = [];


    protected $errorMsg = '';


    public function __construct($request)
    {
        $this->request = $request;
    }


    /**
     * :
     *
     * @param $className
     * @throws Exception
     * @throws TypeStringException
     */
    public function setValidateClass($className)
    {
        if (!is_string($className)) {
            throw new TypeStringException('$className 应该是字符串');
        }

        if (!class_exists($className)) {
            throw new Exception($className  . '类不存在');
        }

        $this->validateClass = $className;
    }

    /**
     * :
     *
     * @param $action
     * @throws TypeStringException
     */
    public function setAction($action)
    {
        if (!is_string($action)) {
            throw new TypeStringException('$action 应该是字符串');
        }
        $this->action = $action;
    }

    /**
     * :
     *
     * @param array $param
     */
    public function setParam(array $param)
    {
        $this->param = $param;
    }

    /**
     * :
     *
     */
    protected function init()
    {
        //获取实例类
        $this->getValidateClass();

        //实例化对象
        $this->getValidateObj();

        //获取操作 action
        $this->getAction();

        //获取操作的数据
        $this->getParam();
    }


    /**
     * :验证数据
     *
     * @return mixed
     */
    public function check()
    {
        //初始化
        $this->init();

        //获取需要检验的规则
        $validateRule = $this->validateObj->getRuleByAction($this->action);

        $result =  $this->validateObj->check($this->param, $validateRule);

        if ($result !== true) {
            $this->errorMsg = $this->validateObj->getError();
        }
        return $result;
    }

    /**
     * :
     *
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }









}