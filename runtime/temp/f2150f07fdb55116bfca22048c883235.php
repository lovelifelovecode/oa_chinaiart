<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:75:"/var/www/oa_chinaiart/public/../application/admin/view/commission/list.html";i:1524638773;s:54:"/var/www/oa_chinaiart/application/admin/view/base.html";i:1524558175;}*/ ?>
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
                                        <li class="active">订单提成列表</li>
                                        </ul>
                </div>
                <!-- /Page Breadcrumb -->

                <!-- Page Body -->
                <div class="page-body">
                    
<button type="button" tooltip="添加提成配置" class="btn btn-sm btn-azure btn-addon" onClick="javascript:window.location.href = '<?php echo url('add'); ?>'"> <i class="fa fa-plus"></i> Add
</button>
<form class="col-lg-9" style="float: right;" action="" method="post">
  <div class="col-lg-9" style="float:right; padding-bottom: 4px;">
    <div class="input-group">
      <input type="text" class="form-control" name="search" placeholder="Search for...">
      <span class="input-group-btn">
        <button class="btn btn-default" type="submit">Go!</button>
      </span>
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</form>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="widget">
            <div class="widget-body">
                <div class="flip-scroll">
                    <table class="table table-bordered table-hover">
                        <thead class="">
                            <tr>
                                <th class="text-center"><a href="<?php echo url('list',['column'=>'commission_id','order'=>$order]); ?>">ID</a></th>
                                <th class="text-center"><a href="<?php echo url('list',['column'=>'commission_order_id','order'=>$order]); ?>">订单名称</a></th>
                                <th class="text-center"><a href="<?php echo url('list',['column'=>'commission_order_title','order'=>$order]); ?>">完成时间</a></th>
                                <th class="text-center">订单总额</th>
                                <th class="text-center">评分等级</th>
                                <th class="text-center">提成总额</th>
                                <th class="text-center">分配比例</th>
                                <th class="text-center"><a href="<?php echo url('list',['column'=>'commission_operator','order'=>$order]); ?>">上一操作人</a></th>
                                <th class="text-center">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): if( count($list)==0 ) : echo "" ;else: foreach($list as $key=>$vo): ?>
                                    <tr>
                                        <td align="center"><?php echo $vo['commission_id']; ?></td>
                                        <td align="center"><?php echo $vo['order_data']['order_title']; ?></td>
                                        <td align="center"><?php echo date("Y-m-d",$vo['commission_complete_settime']);  ?></td>
                                        <td align="center"><?php echo $vo['order_data']['order_price']; ?>元</td>
                                        <td align="center"><?php echo $vo['rule_data']['rule_name']; ?></td>
                                        <td align="center"><?php echo $vo['commission_total']; ?>元</td>
                                        <td align="center">
<?php if(is_array($vo['percentageArr']) || $vo['percentageArr'] instanceof \think\Collection || $vo['percentageArr'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['percentageArr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$lo): $mod = ($i % 2 );++$i;?>
        <?php echo $lo; ?>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php endforeach; endif; else: echo "" ;endif; ?>

<br>
<?php endforeach; endif; else: echo "" ;endif; ?>
                                        </td>
                                        <td align="center"><?php echo $vo['commission_operator']; ?></td>
                                        <td align="center">
                                            <a href="<?php echo url('edit',['commission_id'=>$vo['commission_id']]); ?>" class="btn btn-primary btn-sm shiny">
                                                <i class="fa fa-edit"></i> 编辑
                                            </a>
                                            <a href="#" onClick="warning('确实要删除吗', '<?php echo url('del',['commission_id'=>$vo['commission_id']]); ?>')" class="btn btn-danger btn-sm shiny">
                                                <i class="fa fa-trash-o"></i> 删除
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                    <p><div class="pagination pagination-sm pull-right"><?php echo $list->render(); ?></div></p>
                </div>
                <div>
                                    </div>
            </div>
        </div>
    </div>
</div>

                </div>
                <!-- /Page Body -->
            </div>

            <!-- /Page Content -->
		</div>	
	</div>

	    <!--Basic Scripts-->
    <script src="/static/admin/style/bootstrap.js"></script>
    <!--Beyond Scripts-->
    <script src="/static/admin/style/beyond.js"></script>
</body></html>