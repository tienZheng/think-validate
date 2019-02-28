<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/25
 * Time: 9:57 PM
 */

namespace Tien\ThinkValidate;


use Tien\ThinkValidate\exceptions\Exception;
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

    /**
     * 验证规则为空是否继续
     *
     * @var bool
     */
    protected $emptyIsContinue = false;


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
     * @param $continue
     */
    public function setEmptyIsContinue($continue)
    {
        $this->emptyIsContinue = $continue;
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

        //如果验证规则为空，且为空时不执行
        if (empty($validateRule) && false === $this->emptyIsContinue) {
            return true;
        }

        $result = $this->validateObj->check($this->param, $validateRule);

        if ($result !== true) {
            $this->errorMsg = $this->validateObj->getError();
            return $result;
        }

        //checkTienStrict
        if (!$this->checkTienStrict()) {
            return false;
        }

        //checkTienMaxNum
        if (!$this->checkTienMaxNum()) {
            return false;
        }

        if (!$this->checkTienMinNum()) {
            return false;
        }
        return $result;
    }

    protected function checkTienStrict()
    {
        if ($this->validateObj->getTiemStrictBool()) {
            $illegalKeys = array_diff(array_keys($this->param), $this->validateObj->getCheckRule());
            if (!empty($illegalKeys)) {
                $this->errorMsg = implode(',', $illegalKeys) . '是非法参数字符';
                return false;
            }
        }
        return true;
    }


    protected function checkTienMaxNum()
    {
        $max = $this->validateObj->getTienMaxNum();
        if ($max && count($this->param) > $max) {
            $this->errorMsg = '参数的个数不能大于' . $max;
            return false;
        }
        return true;
    }

    /**
     * :
     *
     * @return bool
     */
    protected function checkTienMinNum()
    {
        $min = $this->validateObj->getTienMinNum();
        if ($min && count($this->param) < $min) {
            $this->errorMsg = '参数的个数不能小于' . $min;
            return false;
        }
        return true;
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