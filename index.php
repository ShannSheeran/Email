<?php
/**
 * Created by PhpStorm.
 * User: sheeran
 * Date: 2017/3/17
 * Time: 14:21
 */
class Email{


    /**
    +----------------------------------------------------------
     * 功能：系统邮件发送函数
    +----------------------------------------------------------
     * @param string $to    接收邮件者邮箱
     * @param string $name  接收邮件者名称
     * @param string $subject 邮件主题
     * @param string $body    邮件内容
     * @param string $attachment 附件列表
    +----------------------------------------------------------
     * @return boolean
    +----------------------------------------------------------
     */
    public  static function  sendemail($to, $name, $subject = '', $body = '', $attachment = null, $config = '')
    {
        $config = self::getConfig();
        include './PHPMailer/phpmailer.class.php';//从PHPMailer目录导class.phpmailer.php类文件
        $mail = new \PHPMailer();                           //PHPMailer对象
        $mail->CharSet = 'UTF-8';                         //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->IsSMTP();                                   // 设定使用SMTP服务
        //$mail->IsHTML(true);
        $mail->SMTPDebug = 0;                             // 关闭SMTP调试功能 1 = errors and messages2 = messages only
        $mail->SMTPAuth = true;                           // 启用 SMTP 验证功能
        if ($config['smtp_port'] == 465)
            $mail->SMTPSecure = 'ssl';                    // 使用安全协议
        $mail->Host = $config['smtp_host'];                // SMTP 服务器
        $mail->Port = $config['smtp_port'];                // SMTP服务器的端口号
        $mail->Username = $config['smtp_user'];           // SMTP服务器用户名
        $mail->Password = $config['smtp_pass'];           // SMTP服务器密码
        $mail->SetFrom($config['from_email'], $config['from_name']);
        $replyEmail = $config['reply_email'] ? $config['reply_email'] : $config['reply_email'];
        $replyName = $config['reply_name'] ? $config['reply_name'] : $config['reply_name'];
        $mail->AddReplyTo($replyEmail, $replyName);
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($to, $name);
        if (is_array($attachment)) { // 添加附件
            foreach ($attachment as $file) {
                if (is_array($file)) {
                    is_file($file['path']) && $mail->AddAttachment($file['path'], $file['name']);
                } else {
                    is_file($file) && $mail->AddAttachment($file);
                }
            }
        } else {
            is_file($attachment) && $mail->AddAttachment($attachment);
        }
        return $mail->Send() ? true : $mail->ErrorInfo;
    }

    /*
     *
     */
    public static function getConfig()
    {
        $config=[
            'smtp_host'=>'smtp.exmail.qq.com',
            'smtp_port'=>465,
            'from_email'=>'1018707338@qq.com',
            'from_name'=>'followbee在线展位预定平台',
            'smtp_user'=>'1018707338@qq.com',
            'smtp_pass'=>'wolfboy123@',
            'reply_email'=>'1018707338@qq.com',
            'reply_name'=>' Follow Bee'
        ];
        return $config;
    }

    public static function p($param)
    {
        echo '<pre>';
        print_r($param);
        echo '<pre>';
    }
}
$to='duzhengwei@3ncto.com';
$name='sheeran';
$subject='测试';
$body='This is body';
$send=Email::sendemail($to, $name, $subject, $body);
Email::p($send);

