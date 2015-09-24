# Blog

I want to use pjax and nprogress to display the content.Please waiting for the cool thing.

#架构说明
 -----
 
 项目主文件夹：apps，用于存放逻辑代码，配置文件，日志等内容，系统一共有三个模块，分别是frontend(前台),user(用户),backend(后台).core目录下是模型类(models),操作类(operations)和工具类(utils).
 ~~~
 apps/  项目主文件夹
    backend/ 后台模块
      controllers/ 控制器
      views/ 视图
     
    configs/ 配置
    
    observers/ 观察者模块
    
    subjects/ 观察对象类
    
    core/ 核心功能模块
      models/ 模型
      operations/ 操作类
      utils/ 工具类
      controllers/ 控制器类
      components/ 组件
      
    frontend/ 前台模块
    
    logs/ 日志
    
    user/ 用户模块
 ~~~
 
 缓存目录：cache,缓存文件存放位置，分别包括视图缓存等内容
  ~~~
  cache/ 缓存
    views/ 视图缓存
  ~~~
  
 公共目录：public,保存项目的静态文件，如css,js,images等内容
  ~~~
  public/ 公共目录
    css/ css文件
    editor/ 编辑器
    js/ js文件
    fonts/ 字体
    images/ 图片
	index.php 引导文件  
 ~~~
    
项目将使用Echarts来显示数据图表
  

