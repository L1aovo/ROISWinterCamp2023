## double_cmd

考点：

1.php伪协议的文件包含

2.双写

```
php://filter/read=convert.base64-encode/resource=index.php
```

相信百度都可以搜到的一个十分常用的伪协议payload

然后，在这个基础上需要绕过$cmd = preg_replace("/flag/i", '', $cmd);

这个语句会将cmd中的flag替换为空，但是只会替换一次，所以只要在flag中加个flag就会出现flflagag这样的字符串，经过preg_replace语句之后会将完整连续的flag替换为空之后将flflagag变成flag，就可以通过preg_match的判定触发include

payload：

```
php://filter/read=convert.base64-encode/resource=/flflagag
```

然后将得出结果base64解码就行。