<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>APLIKASI PENGADAAN PT ENERGI PELABUHAN INDONESIA</title> 
    <link href="<?=assets;?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=assets;?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?=assets;?>vendors/nprogress/nprogress.css" rel="stylesheet">
    <link href="<?=assets;?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link href="<?=assets;?>vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <link href="<?=assets;?>vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <link href="<?=assets;?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?=assets;?>build/css/custom.min.css" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border:0;">
              <a href="#" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $this->db2_models->row('master_perusahaan',array('kode_register'=>$this->session->userdata('kode_vendor')),'nama_perusahaan'); ?></span></a>
            </div>
            <div class="clearfix"></div>
			<div class="profile clearfix">
              <div class="profile_pic">
                <img src="http:\\portal.ecopowerport.co.id:88\vendor_list\<?php echo $this->db2_models->row('master_pic',array('kode_register'=>$this->session->userdata('kode_vendor')),'file_foto'); ?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $this->db2_models->row('master_pic',array('kode_register'=>$this->session->userdata('kode_vendor')),'nama_pic'); ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />
			<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
				<?php
					$icons = array('1'=>'fa fa-briefcase','2'=>'fa fa-desktop','3'=>'fa fa-edit','4'=>'fa fa-group',
					'5'=>'fa fa-line-chart','6'=>'fa fa-table','7'=>'fa fa-user-md','8'=>'fa fa-table');
					$amenu['uri'] = $this->uri->uri_string;
					$amenu['active'] = $this->mmenu->active_menu();
					$amenu['uri1'] =  $this->uri->segment(1);
					$amenu['uri2'] =  $this->uri->segment(2);
					$amenu['icons'] = $icons;
				?>
				<li class="<?php echo @($amenu['uri1']=='welcome')? "active":""?>">
					<a href="<?php echo base_url();?>welcome/dashboard"><i class="fa fa-home"></i><span class="title">Home</span></a>
				</li>
				<?php foreach($prev['hasil'] as $menu){
					$issub = count($menu['child'])>0; ?>
				<li class="<?php echo @($amenu['active'][0]['menu']==$menu['menu'])? "active open":""?>">
					<a href="<?php echo @($menu['controller'])? base_url().$menu['controller'].'/'.$this->session->userdata('kode_authentifikasi'):"javascript:;";?>">
					<i class="<?php echo @($icons[$menu['id']])? $icons[$menu['id']]:"icon-folder";?>"></i>
					<span class="title"><?php echo $menu['menu']; ?></span>
					<?php if ($issub) { ?><span class="fa fa-chevron-down"></span><?php } ?>
					</a>
					<?php if ($issub) { ?>
					<ul class="nav child_menu">
						<?php foreach($menu['child'] as $submenu) {
							$issub2 = count($submenu['child'])>0; ?>
						<li class="<?php echo @($amenu['active'][1]['menu']==$submenu['menu'])? "active open":""?>">
							<a href="<?php echo @($submenu['controller'])? base_url().$submenu['controller'].'/'.$this->session->userdata('kode_authentifikasi'):"javascript:;";?>">
							<span class="title"><?php echo $submenu['menu']; ?></span>
							<?php if ($issub2) { ?><span class="fa fa-chevron-down"></span><?php } ?>
							</a>
							<?php if ($issub2) { ?>
							<ul class="nav child_men">
								<?php foreach($submenu['child'] as $submenu2) {
									$issub3 = count($submenu2['child'])>0; ?>
								<li class="<?php echo @($amenu['active'][2]['menu']==$submenu2['menu'])? "active":""?>">
									<a href="<?php echo @($submenu2['controller'])? base_url().$submenu2['controller']:"javascript:;";?>">
									<span class="title"><?php echo $submenu2['menu']; ?></span>
									<?php if ($issub3) { ?><span class="fa fa-chevron-down"></span><?php } ?>
									</a>
								</li>
								<?php } ?>
							</ul>
							<?php } ?>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
				</li>
				<?php } ?>
				</ul>
			   </div>
			</div>
			<div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?=base_url();?>welcome/logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
		  </div>
        </div>
		<div class="top_nav fixed-top">
          <div class="nav_menu">
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
              <nav class="nav navbar-nav">
              <ul class=" navbar-right">
                <li class="nav-item dropdown open" style="padding-left: 15px;">
                  <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="http:\\portal.ecopowerport.co.id:88\vendor_list\<?php echo $this->db2_models->row('master_pic',array('kode_register'=>$this->session->userdata('kode_vendor')),'file_foto'); ?>" alt="">
                    <?php echo $this->db2_models->row('master_pic',array('kode_register'=>$this->session->userdata('kode_vendor')),'nama_pic'); ?>
                  </a>
                  <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item"  href="javascript:;"> Profile</a>
                      <a class="dropdown-item"  href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                  <a class="dropdown-item"  href="javascript:;">Help</a>
                    <a class="dropdown-item"  href="<?=base_url();?>welcome/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                  </div>
                </li>

                <li role="presentation" class="nav-item dropdown open">
                  <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul class="dropdown-menu list-unstyled msg_list" role="menu" aria-labelledby="navbarDropdown1">
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="dropdown-item">
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <div class="text-center">
                        <a class="dropdown-item">
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
		<div class="right_col" role="main">
          <div class="row" style="display: inline-block;" >
			<br>
			<br>
			<br>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT --> 
