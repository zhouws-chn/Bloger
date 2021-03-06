## Bloger个人博客系统



### V0.0.1
##### 测试版源码上传
* 实现了手机的首页和电脑的首页显示功能。
* 实现登陆发博文功能
* 嵌入了UEditor编辑器,支持截图上传
* 手机界面功能暂未完善
* 没有可视化的添加用户功能，添加栏目功能(可操作数据库修改)
* 验证码功能未支持
* 上传的文章不支持修改、删除
* 文章的略缩图暂未实现
* 首页的轮播图暂未实现

------

### V0.0.2.20190902.1632

##### 测试版源码上传

- 添加栏目默认缩略图
- 优化了手机端的CSS样式
- 删除了在添加文章页面上传略缩图的功能，后续在文章界面上添加此功能.
- 在文章界面上完成了删除功能,但是并没有检查删除文章内的图片

------

### V0.0.2.20190902.1900

##### 紧急更新

- 修复了V0.0.2.20190902.16.32 中在发布文章界面的BUG。
- 更新了数据库,在articles表中新增了abstract_is字段，类型:bit,长度:1
- 更新了摘要的显示逻辑,如果没有添加摘要，则自动显示文章的内容的前99个字符。
- 上传了数据库文件 blog_data.sql。
- 修复了在IPad上CSS显示混乱。

------

### V0.0.3.20190907.1726

##### 测试版源码上传

- 修复了在Linux系统下文件名大小写报错的问题。
- 添加了对文章修改的功能。
- 添加了栏目管理页面，相关功能暂未实现。

------

### V0.0.4.20190917.0931

##### 测试版源码上传

- 更换了富文本编辑器UEditor为TinyMCE(暂不支持图片上传)
- 添加了登陆验证码功能。
- 更改了文件夹application文件夹的名称(建议用户自己更改)。
- 解决了一些UI的BUG。

------

### V0.0.5.20190917.2110

##### 测试版源码上传

- 富文本编辑器支持从WORD中复制图片上传。
- 调整了登陆界面的UI。

------

### V0.0.6.20190920.1958

##### 测试版源码上传

- 添加了栏目的新增和删除功能（删除栏目时需要验证用户的登陆密码）
- 修复了上一个版本中的BUG。

------

### V0.0.7.20190921.1958

##### 测试版源码上传

- 添加了栏目的编辑功能.

------

### V0.1.0.20191016.2250

##### 测试版源码上传

- 用户管理（修改用户名、修改密码、修改邮箱）.
- 网站管理员权限验证.
- 栏目管理需要验证管理员权限.
- 支持上传设置栏目的略缩图.
- 支持设置栏目的优先级，优先级低于60则在前台导航栏展示.
- 支持远程图片本地化（当复制网上的图片时，会自动下载到服务器本地）.
- 支持文章来源设置，当填写来源时，表示文章为转载，否则是原创.
- 修复图标功能，把图标都修改为了.Font-Awesone.
- 更新了文章阅读量的计算方式,解决了在文章页面刷新网页时，统计量会递增的BUG.

------

### V0.1.0.20191025.2150

##### 测试版源码上传

- 添了轮播图管理功能，支持添加、修改、更换图片的功能（管理员权限）。
- 添了从数据库获取公告信息并展示的功能，暂未添加管理公告的功能（管理员权限）。
- 将管理权限均以tab界面形式展示。

------

### V0.1.0.20191107.1500

##### 测试版源码上传

- 更新了sql文件，使用本程序需要导入最新的sql文件.
- 测试账户登陆，账户:test@test.com 密码:123456
- 网站管理功能暂未完成(网站名称的设置,首页个人信息的展示等).
- 远程图片本地化还有Bug存在，可以通过修改文章内容的html来处理.
- 网站公告不可以全部被删除,否则将无法打开首页,这个问题将在之后的版本中解决。
- 在删除栏目的时候，每删除一个，需要刷新页面后才可以删除下一个，不可以直接删除,此BUG将在下次版本中解决.

------

### V0.1.1.20191111.1018

##### 测试版源码上传

- 解决了上一个版本中的栏目删除Bug
- 完善了文章详情页的UI显示

------

### V0.1.2.20191202.1530

##### 测试版源码上传

- 添加了QQ快捷登陆的功能,请在application/config.php中修改您的appid配置（有第一个登陆失败的BUG）.
- 完成了文章评论的功能.
- 优化了数据库模型结构，删除了冗余的数据库表结构.

------

### V0.1.3.20191209.1625

##### 测试版源码上传

- 修复了QQ互联登陆失败的BUG.
- 修改了后台数据表的结构，隐藏了重要数据类型(id).
- 完善了后台的显示功能.

------

### V0.1.4.20191216.1600

##### 测试版源码上传

- 完善了QQ互联绑定和解除绑定的功能.

------

### V0.2.0.20200107.1614

##### 测试版源码上传，2020新年快乐。

- 添加了云笔记模块.可以在线写笔记（MarkDown暂未实现）。
- 添加了思维导图模块，可以在线编辑思维导图。
- 请更新数据库结构。

