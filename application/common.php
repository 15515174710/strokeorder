<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use tool\Auth;
use PHPMailer\PHPMailer\PHPMailer;

function SendMail($address, $title, $message, $attach = '')
{
    $address = '519707080@qq.com';
    $mail = new PHPMailer();

    // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();
//        $mail->SMTPDebug = 1;
    // 设置邮件的字符编码,若不指定,则为'UTF-8'
    $mail->CharSet = 'UTF-8';

    // 添加收件人地址,可以多次使用来添加多个收件人
    $mail->AddAddress($address);

    // 设置邮件正文
    if (is_array($message)) {
        $mail->MsgHTML($message['content']);
    } else {
        $mail->Body = $message;
    }

    // 设置邮件头的From字段。
    $mail->From = 'rene@aupiao.com';
    // 设置发件人名字
    $mail->FromName = 'TicketMother';

    // 设置邮件标题
    $mail->Subject = $title;

    // 设置SMTP服务器。
    $mail->Host = 'ssl://smtp.exmail.qq.com';
    $mail->Port = 465;
    // 设置为“需要验证”
    $mail->SMTPAuth = true;

    // 设置用户名和密码。
    $mail->Username = 'rene@aupiao.com';
    $mail->Password = 'Aaa123';
    $mail->AddAttachment();
    //$mail->AddAttachment($path, $name = '', $encoding = 'base64', $type = 'application/octet-stream')
    if (!empty($attach)) {
        $mail->AddAttachment($attach, basename($attach));
    }
    // 发送邮件。
    if (!$mail->Send()) {
        echo 'send to ' . $address . 'error info:' . $mail->ErrorInfo;
        return false;
    }
    return true;
}

/**
 * 生产密码
 * @param $password
 * @return string
 */
function makePassword($password)
{

    return md5($password . config('whisper.salt'));
}

/**
 * 检测密码
 * @param $dbPassword
 * @param $inPassword
 * @return bool
 */
function checkPassword($inPassword, $dbPassword)
{

    return (makePassword($inPassword) == $dbPassword);
}

/**
 * 获取mysql 版本
 * @return string
 */
function getMysqlVersion()
{

    $conn = mysqli_connect(
        config('database.hostname') . ":" . config('database.hostport'),
        config('database.username'),
        config('database.password'),
        config('database.database')
    );

    return mysqli_get_server_info($conn);
}

/**
 * 生成layui子孙树
 * @param $data
 * @return array
 */
function makeTree($data)
{

    $res = [];
    $tree = [];

    // 整理数组
    foreach ($data as $key => $vo) {
        $res[$vo['id']] = $vo;
        $res[$vo['id']]['children'] = [];
    }
    unset($data);

    // 查询子孙
    foreach ($res as $key => $vo) {
        if ($vo['pid'] != 0) {
            $res[$vo['pid']]['children'][] = &$res[$key];
        }
    }

    // 去除杂质
    foreach ($res as $key => $vo) {
        if ($vo['pid'] == 0) {
            $tree[] = $vo;
        }
    }
    unset($res);

    return $tree; // 19 20 12 12
}

/**
 * 打印调试函数
 * @param $data
 */
function dump($data)
{

    echo "<pre>";
    print_r($data);
}

/**
 * 标准返回
 * @param $code
 * @param $data
 * @param $msg
 * @return \think\response\Json
 */
function reMsg($code, $data, $msg)
{

    return json(['code' => $code, 'data' => $data, 'msg' => $msg]);
}

/**
 * model返回标准函数
 * @param $code
 * @param $data
 * @param $msg
 * @return array
 */
function modelReMsg($code, $data, $msg)
{

    return ['code' => $code, 'data' => $data, 'msg' => $msg];
}


/**
 * 根据ip定位
 * @param $ip
 * @return string
 * @throws Exception
 */
function getLocationByIp($ip)
{
    $ip2region = new \Ip2Region();
    $info = $ip2region->btreeSearch($ip);

    $info = explode('|', $info['region']);

    $address = '';
    foreach ($info as $vo) {
        if ('0' !== $vo) {
            $address .= $vo . '-';
        }
    }

    return rtrim($address, '-');
}

/**
 * 按钮检测
 * @param $input
 * @return bool
 */
function buttonAuth($input)
{
    $authModel = Auth::instance();
    return $authModel->authCheck($input, session('admin_role_id'));
}

//充值订单号
function create_recharge_order_sn()
{
    return date('ymdhis') . date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}


function msgToJson($data = [], $code = 0, $message = '成功')
{
    echo json_encode(['code' => $code, 'data' => $data, 'msg' => $message]);
    exit;
}

function dd($data = [])
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    die;
}

//生成随机唯一token
function getRoundToken()
{
    $token = md5(uniqid(md5(microtime(true)), true));
    return $token;
}