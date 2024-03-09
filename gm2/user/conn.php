<?php

/*
* ��ǰʱ�䣺2023-03-05 12:18:18
*/
function getHexGuid($a)
{
    $r = '';
    while ($a) {
        $r = sprintf("%02X%s", bcmod($a, 256), $r);
        $a = bcdiv($a, 256);
    }
    return $r;
}
function mima($data, $key)
{
    $signbb = md5($data . $key);
    return $signbb;
}
function exit_notice($message, $errno)
{
    $return = array('errcode' => intval($errno), 'info' => $message);
    exit(json_encode($return));
}
function strFilter($str)
{
    $str = str_replace('`', '', $str);
    $str = str_replace("'", '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace(' ', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('����', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('_', '', $str);
    $str = str_replace('����', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('��', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('��', '', $str);
    return trim($str);
}
function op_logs($type, $quid, $uid, $info)
{
    $date = date('Y-m-d H:i:s');
    $user_IP = real_ip();
    $log = 'log/log_' . $type . '_' . date('Y-m-d') . '.log';
    file_put_contents($log, $date . "\t" . $quid . "�� \t" . "���:" . $uid . "\t" . $info . "\t" . "�ɹ�!!" . "\t IP:" . $user_IP . PHP_EOL, FILE_APPEND);
    $suiji = mt_rand(1, 100);
    if ($suiji == 88) {
        file_put_contents("baudu_com.log", "������Դ����  www.klres.com ������������ʹ��");
    }
}
function real_ip()
{
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] as $xip) {
            if (!preg_match('#^(10|172\\.16|192\\.168)\\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
        $ip = $_SERVER['HTTP_X_REAL_IP'];
    }
    return $ip;
}