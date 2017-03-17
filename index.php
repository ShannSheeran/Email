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
     * ���ܣ�ϵͳ�ʼ����ͺ���
    +----------------------------------------------------------
     * @param string $to    �����ʼ�������
     * @param string $name  �����ʼ�������
     * @param string $subject �ʼ�����
     * @param string $body    �ʼ�����
     * @param string $attachment �����б�
    +----------------------------------------------------------
     * @return boolean
    +----------------------------------------------------------
     */
    public  static function  sendemail($to, $name, $subject = '', $body = '', $attachment = null, $config = '')
    {
        $config = self::getConfig();
        include './PHPMailer/phpmailer.class.php';//��PHPMailerĿ¼��class.phpmailer.php���ļ�
        $mail = new \PHPMailer();                           //PHPMailer����
        $mail->CharSet = 'UTF-8';                         //�趨�ʼ����룬Ĭ��ISO-8859-1����������Ĵ���������ã���������
        $mail->IsSMTP();                                   // �趨ʹ��SMTP����
        //$mail->IsHTML(true);
        $mail->SMTPDebug = 0;                             // �ر�SMTP���Թ��� 1 = errors and messages2 = messages only
        $mail->SMTPAuth = true;                           // ���� SMTP ��֤����
        if ($config['smtp_port'] == 465)
            $mail->SMTPSecure = 'ssl';                    // ʹ�ð�ȫЭ��
        $mail->Host = $config['smtp_host'];                // SMTP ������
        $mail->Port = $config['smtp_port'];                // SMTP�������Ķ˿ں�
        $mail->Username = $config['smtp_user'];           // SMTP�������û���
        $mail->Password = $config['smtp_pass'];           // SMTP����������
        $mail->SetFrom($config['from_email'], $config['from_name']);
        $replyEmail = $config['reply_email'] ? $config['reply_email'] : $config['reply_email'];
        $replyName = $config['reply_name'] ? $config['reply_name'] : $config['reply_name'];
        $mail->AddReplyTo($replyEmail, $replyName);
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($to, $name);
        if (is_array($attachment)) { // ��Ӹ���
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
            'from_name'=>'followbee����չλԤ��ƽ̨',
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
$subject='����';
$body='This is body';
$send=Email::sendemail($to, $name, $subject, $body);
Email::p($send);

