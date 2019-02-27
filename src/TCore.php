<?php
/**
 * Created by PhpStorm.
 * User: Tien
 * Date: 2019/2/26
 * Time: 10:52 PM
 */

namespace Tien\ThinkValidate;


class TCore
{
    use Core;

    protected $rule = [
        'id|标识符' => 'require|gt:0',
        'name|姓名' => 'require|max:16',
        'mobile|手机号' => 'require|mobile',
        'token|密钥' => 'require|length:32'
    ];

    protected $scene = [
        'create' => ['id', 'name', 'mobile', 'token', 'tien_strict'],
        'update' => ['id', 'token', 'name_no', 'mobile_no', 'tien_min_3', 'tien_max_4'],
        'show'   => ['id', 'token', 'error'],
    ];
}