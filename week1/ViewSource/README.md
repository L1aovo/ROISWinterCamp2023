# writeup for ViewSource
修改最后几句代码逻辑
```
var your_flag=prompt('尊敬的黑客！请输入我'+'的flag','ROIS{*****'+'}'),my_flag=_0x3e480a(0x13d,0x10d,0x10f,0x122)+'n0w_Html_A'+_0x3c2226(-0xe,-0x24,-0x15,-0x2a)+_0x3c2226(-0x41,-0x24,-0x30,-0x19)+_0x3c2226(-0x34,-0x49,-0x31,-0x4f);your_flag==my_flag?alert(my_flag):location[_0x3c2226(-0x2f,-0x52,-0x3f,-0x4d)]='/'
```
修改为
```
var your_flag=prompt('尊敬的黑客！请输入我'+'的flag','ROIS{*****'+'}'),my_flag=_0x3e480a(0x13d,0x10d,0x10f,0x122)+'n0w_Html_A'+_0x3c2226(-0xe,-0x24,-0x15,-0x2a)+_0x3c2226(-0x41,-0x24,-0x30,-0x19)+_0x3c2226(-0x34,-0x49,-0x31,-0x4f);your_flag!=my_flag?alert(my_flag):location[_0x3c2226(-0x2f,-0x52,-0x3f,-0x4d)]='/'
```
这样输入任何不等于flag值都会将flag alert出来