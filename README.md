# crawl-qiubai-and-send-sms
抓取糗百首页笑话，每小时使用短信发送到指定的手机号码，写来哄女朋友开心的。因为伟大的composer，本项目就几行代码，见main.php

## 使用方法
```bash
git clone git@github.com:shellus/crawl-qiubai-and-send-sms.git
cd crawl-qiubai-and-send-sms
composer install
cp .env.example .env
#编辑.env文件，修改其中必要的配置

```

创建定时执行任务，例如centos下添加crontab -e记录：

`0 */1 * * * cd /home/shellus/www/php/sms_send && php main.php >> ~/sms_log.log 2>&1`

## 相关链接
短信宝(推广链接): [http://www.smsbao.com/reg](http://www.smsbao.com/reg?r=10367)

糗事百科: [http://www.qiushibaike.com/](http://www.qiushibaike.com/)
