
使用指南：
   
     1. 使用流程
     
        开发者需要再Const.php文件中配置CONFIG_PARTNERID、CONFIG_ASEKEY、CONFIG_CLIENT_SECRET者3个常量，该常量可
     
     在seller后台查询, 然后查看实例demo文件：Demo.php、DemoSyn.php 进行开发
    
     2. SDK说明
       
        A.文件介绍
         
          Demo.php             接口请求demo
         
          DemoSyn.php          接收订单状态同步demo
         
          AccessToken.php      获取令牌类
         
          MfwEncrypt.php       加密解密类
         
          Openapi.php          接口请求实现类
          
          OrderSyn.php         接口订单状态实现类
          
          SdkBase.php          基类
         
          READEME.md           sdk介绍
       
        B. 提供的接口
           
            a. 接口请求实现类(Openapi.php)：
            
                 <1> 接口名称：send() 请求接口
            
                     接口参数：action: 请求动作，data: 业务请求参数
            
                     返回参数：bool  成功或者失败   
            
                     ps:  获取请求结果：$obj→getData(), 获取请求错误码：$obj→getErrno(), 
                     获取错误信息：$obj→getLastError()
                
                 <2> 接口名称：parseRes()  解析马蜂窝返回结果
                     
                     接口参数：data: 马蜂窝返回的参数
                                 
                     返回参数：bool 解析成功或者失败
                     
                     ps:  获取解析结果：$obj→getData(), 获取请求错误码：$obj→getErrno(), 
                     获取错误信息：$obj→getError()
            
            b.获取令牌类(AccessToken.php)：
            
                 <1> 接口名称：getAccessToken() 获取令牌
            
                     接口参数：无
            
                     返回参数：string  令牌字符串
            
            c.加密解密类(MfwEncrypt.php)：
            
                 <1> 接口名称：sEncryptData()/ aDecryptData() 加密/解密
            
                     接口参数：sData:需要解密解密数据 ， sKey:分配给商家的秘钥
            
            d.接收订单状态同步实现类(OrderSyn.php)：
            
                 <1> 接口名称：checkAuth()  认证接口
            
                     接口参数：postData: 马蜂窝post请求数据
            
                     返回参数：bool 是否通过认证（签名认证）
                       
                 <2> 接口名称： getReturn()  返回马蜂窝请求接口
            
                     接口参数：isSuccess: 是否成功，msg: 错误信息（可选）
            
                     返回参数：string 解密后的结果，直接返回即可
           
            e.获取结果、错误码、错误信息接口(Openapi.php、OrderSyn.php);
                
                 <1> 接口名称：getErrno() 获取错误码
                      
                     接口参数：无
                     
                     返回参数：int 
                 
                 <2> 接口名称：getError() 获取错误信息
                                       
                     接口参数：无
                                      
                     返回参数：string
                     
                 <3> 接口名称：getData() 获取错误码
                                           
                     接口参数：无
                                          
                     返回参数：array
                     
