<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"/var/www/oa_chinaiart/public/../application/admin/view/commission/add.html";i:1524558175;s:54:"/var/www/oa_chinaiart/application/admin/view/base.html";i:1524558175;}*/ ?>
<!DOCTYPE html>
<html><head>
	    <meta charset="utf-8">
    <title>skyuse OA</title>

    <meta name="description" content="Dashboard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!--Basic Styles-->
    <link href="/static/admin/style/bootstrap.css" rel="stylesheet">
    <link href="/static/admin/style/font-awesome.css" rel="stylesheet">
    <link href="/static/admin/style/weather-icons.css" rel="stylesheet">

    <!--Beyond styles-->
    <link id="beyond-link" href="/static/admin/style/beyond.css" rel="stylesheet" type="text/css">
    <link href="/static/admin/style/demo.css" rel="stylesheet">
    <link href="/static/admin/style/typicons.css" rel="stylesheet">
    <link href="/static/admin/style/animate.css" rel="stylesheet">


    <script src="/static/admin/style/jquery.js"></script>
    <script src="/static/admin/style/jquery_002.js"></script>
    
</head>
<body>
	<!-- 头部 -->
	<div class="navbar">
    <div class="navbar-inner">
        <div class="navbar-container">
            <!-- Navbar Barnd -->
            <div class="navbar-header pull-left" style="padding-top: 10px;">
                <a href="#" class="navbar-brand">
                    <!-- <small>
                            <img src="/static/admin/images/logo.png" alt="">
                        </small> -->
                    天用设计提成
                </a>
            </div>
            <!-- /Navbar Barnd -->
            <!-- Sidebar Collapse -->
            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="collapse-icon fa fa-bars"></i>
            </div>
            <!-- /Sidebar Collapse -->
            <!-- Account Area and Settings -->
            <div class="navbar-header pull-right">
                <div class="navbar-account">
                    <ul class="account-area">
                        <li>
                            <a class="login-area dropdown-toggle" data-toggle="dropdown">
                                <div class="avatar" title="View your public profile">
                                    <img src="/static/admin/images/adam-jansen.jpg">
                                </div>
                                <section>
                                    <h2><span class="profile"><span><?php echo session('user.user_username'); ?></span></span></h2>
                                </section>
                            </a>
                            <!--Login Area Dropdown-->
                            <ul class="pull-right dropdown-menu dropdown-arrow dropdown-login-area">
                                <li class="username"><a>David Stevenson</a></li>
                                <li class="dropdown-footer">
                                    <a href="<?php echo url('user/passwordEdit'); ?>">
                                            修改密码
                                        </a>
                                </li>
                                <li class="dropdown-footer">
                                    <a href="<?php echo url('login/logout'); ?>">
                                            退出登录
                                        </a>
                                </li>
                            </ul>
                            <!--/Login Area Dropdown-->
                        </li>
                        <!-- /Account Area -->
                        <!--Note: notice that setting div must start right after account area list.
                            no space must be between these elements-->
                        <!-- Settings -->
                    </ul>
                </div>
            </div>
            <!-- /Account Area and Settings -->
        </div>
    </div>
</div>

	<!-- /头部 -->
	
	<div class="main-container container-fluid">
		<div class="page-container">
			            <!-- Page Sidebar -->
            <div class="page-sidebar" id="sidebar">
                <!-- Page Sidebar Header-->
                <div class="sidebar-header-wrapper">
                    <input class="searchinput" type="text">
                    <i class="searchicon fa fa-search"></i>
                    <div class="searchhelper">Search Reports, Charts, Emails or Notifications</div>
                </div>
                <!-- /Page Sidebar Header -->
                <!-- Sidebar Menu -->
                <ul class="nav sidebar-menu">
                    <!--Dashboard-->
                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-user"></i>
                            <span class="menu-text">管理员</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?php echo url('user/list'); ?>">
                                    <span class="menu-text">
                                        用户列表                           </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo url('role/list'); ?>">
                                    <span class="menu-text">
                                        角色列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo url('authority/list'); ?>">
                                    <span class="menu-text">
                                        权限列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>

                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-tasks"></i>
                            <span class="menu-text">订单</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?php echo url('order/list'); ?>">
                                    <span class="menu-text">
                                        订单列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li> 

                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-life-ring"></i>
                            <span class="menu-text">提成</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <!-- <li>
                                <a href="<?php echo url('group/list'); ?>">
                                    <span class="menu-text">
                                        小组列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li> -->
                            <li>
                                <a href="<?php echo url('user_commission/list'); ?>">
                                    <span class="menu-text">
                                        个人提成列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo url('commission/list'); ?>">
                                    <span class="menu-text">
                                        订单提成列表                                    </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li> 

                    <li>
                        <a href="#" class="menu-dropdown">
                            <i class="menu-icon fa fa-gear"></i>
                            <span class="menu-text">系统</span>
                            <i class="menu-expand"></i>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="<?php echo url('rule/list'); ?>">
                                    <span class="menu-text">
                                        提成等级配置                                   </span>
                                    <i class="menu-expand"></i>
                                </a>
                            </li>
                        </ul>                            
                    </li>                        
                    
                                           
                    
                </ul>
                <!-- /Sidebar Menu -->
            </div>
            <!-- /Page Sidebar -->
            <!-- Page Content -->

           <div class="page-content">
                <!-- Page Breadcrumb -->
                <div class="page-breadcrumbs">
                    <ul class="breadcrumb">
                                        <li>
                        <a href="<?php echo url('commission/list'); ?>">订单提成列表</a>
                    </li>             
                    <li class="active">新增小组提成</li>
                                        </ul>
                </div>
                <!-- /Page Breadcrumb -->

                <!-- Page Body -->
                <div class="page-body">
                    
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-header bordered-bottom bordered-blue">
                <span class="widget-caption">新增小组提成</span>
            </div>
            <div class="widget-body">
                <div id="horizontal-form">
                    <form class="form-horizontal" role="form" action="" method="post">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label no-padding-right">订单名称</label>
                            <div class="col-sm-6">
                                <select name="commission_order_id" style="width: 100%;">
                                    <option value="0" selected="selected">请选择订单</option>
                                    <?php if(is_array($orders) || $orders instanceof \think\Collection || $orders instanceof \think\Paginator): if( count($orders)==0 ) : echo "" ;else: foreach($orders as $key=>$vo): ?>
                                    <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                            <p class="help-block col-sm-4 red">* 必填 (只有完成的订单才会会显示)</p>
                        </div> 
                        
                         <div class="form-group">
                            <div style="display: block">
                            <label for="title" class="col-sm-2 control-label no-padding-right">用户名</label>
                            <div class="col-sm-6">
                                <select id="testSelect" name="commission_user_id[]" style="width: 100%;">
                                    <option value="0" selected="selected">请选择用户</option>
<?php reset($users); for($i=0,$n= count($users);$i<$n;$i++){
                                        echo "<option value=" . key($users) .">". $users[key($users)] ."</option>";
                                        next($users);
} ?>
                                </select>
                            </div>
                            <p class="help-block  red"  style="padding: 0"><input type="float" name="percentage[]">%<span class="addBut" style="margin-left: 10px;font-size: 18px">+</span></p>
                            <br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="is_show" class="col-sm-2 control-label no-padding-right">是否关闭</label>

                            <div class="col-xs-4">
                                <label>
                                    <input class="checkbox-slider slider-icon yesno" name="is_show" checked="checked" type="checkbox">
                                    <span class="text"></span>
                                </label>
                            </div>                            
                        </div>
                        <!-- <input name="id" value="19" type="hidden"> -->
                        <input name="commission_operator" value="<?php echo session('user.user_username'); ?>" type="hidden">
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">保存信息</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


                </div>
                <!-- /Page Body -->
            </div>
<script type="text/javascript">
    var s = '     <label for="title" class="col-sm-2 control-label no-padding-right">用户名</label>\n' +
    '     <div class="col-sm-6">\n' +
    '         <select id="testSelect" name="commission_user_id[]" style="width: 100%;">\n' +
    '             <option value="0" selected="selected">请选择用户</option>\n' +
    '             <?php reset($users); for($i=0,$n= count($users);$i<$n;$i++){echo "<option value=" . key($users) .">". $users[key($users)] ."</option>"; next($users); } ?>\n' +
    '         </select>\n' +
    '         \n' +
    '     </div>\n' +
    '     <p class="help-block  red"  style="padding: 0"><input type="float" name="percentage[]"><span class="addBut"  style="margin-left: 10px;font-size: 18px"></span></p >'


    $('.addBut').on('click',function(){
        
        console.log($(this).parent().parent().append(s));
    })
</script>

            <!-- /Page Content -->
		</div>	
	</div>

	    <!--Basic Scripts-->
    <script src="/static/admin/style/bootstrap.js"></script>
    <!--Beyond Scripts-->
    <script src="/static/admin/style/beyond.js"></script>
</body></html>