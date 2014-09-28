<?php

/**
 * 
 * 国都短信接口---系统
 * 状态码	说明
00	　批量短信提交成功（批量短信待审批）
01	　批量短信提交成功（批量短信跳过审批环节）
02	　IP限制
03	　单条短信提交成功
04	　用户名错误
05	 密码错误
06	 剩余条数不足
07	 信息内容中含有限制词(违禁词)
08	　信息内容为黑内容
09	　该用户的该内容 受同天内，内容不能重复发 限制
10	 批量下限不足
	
97	　短信参数有误
98	　防火墙无法处理这种短信
99	　短信参数无法解析
 */
class GuoDuHolder implements SMSHolder {

    // 以长短信的形式发送，15是以普通短信方式发送
    const CONTENT_TYPE = 8;
    
    private $openId = 'hmeikl';
    private $password = 'lu1125';
    private $apiUrl = "http://221.179.180.158:9007/QxtSms/QxtFirewall";
    private $errorMsg;
    
    public function getError() {
        return $this->errorMsg;
    }

    public function send($mobile, $content) {
        
        $content = mb_convert_encoding($content, 'gbk', 'utf-8');
        /* 将手机号从数组转变成一个用逗号分开的字符串，字符串末尾有逗号不影响消息下发。 */
        $CommString = "OperID=" . $this->openId . "&OperPass=" . $this->password . "&SendTime=&ValidTime=&AppendID=&DesMobile=$mobile&Content=" . urlencode($content) . "&ContentType=" . self::CONTENT_TYPE;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $CommString);
        
        $response = simplexml_load_string(curl_exec($ch));
        $success = $response->code == '03';
        
        if (!$success) {
            $this->errorMsg = get_class($this) . " error code " . $response->code;
        }
        
        return $success;
    }

}
