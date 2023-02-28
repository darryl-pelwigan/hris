 <body id="">
      <div class="container-fluid pcc-brand ">
            <div class="text-center" style="margin-top: 5px;">
            <a class="navbar-brand-pcc"> <img src="<?=base_url('assets/images/logo.png')?>" style="width:25px;"> Pines City Colleges - HUMAN RESOURCE INFORMATION SYSTEM</a>
            </div>
            <?php if($this->session->userdata('role') != 7): ?>
                <div class="text-left back-url">
                    <a href="<?=ROOT_URL?>pcc_dashboard.php"><i class="fa fa-caret-left"></i> <small>Back to</small> PCC-OISMS<b></b></a>
                </div>
            <?php endif; ?>

           <!--  <ul class="nav navbar-top-links navbar-right pcc-brand-left">
                <li class="toUppercase"></li>
                <li class="user-separator">&nbsp;</li>
                <li style="color:#006600;"></li>
            </ul> -->
        </div>

        <nav class="navbar navbar-expand navbar-default  static-top">
            <div class="navbar-header nav-header-hr">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand navbar-brand-hr" href="index.html">H R  I S</a>
                <div class="pull-right">
                    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
            <ul class="nav navbar-top-links">

                <li class="dropdown_item_menu" id="dropdown_notification_item">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="notification_load">
                        <i class="fa fa-bell fa-fw"></i> 
                        <span class="badge" style="background-color: #fa3e3e; color: white; top: 0; right: 0;" id="count_notification"></span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts" id="notification_lists" style="text-align:center; overflow: auto; max-height: 400px; z-index: 9999;">
                    </ul>
                </li>
                
                <!-- message notification for expiry license -->
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="expire_notif_load">
                        <i class="fa fa-envelope fa-fw"></i> 
                        <span class="badge" style="background-color: #fa3e3e; color: white; top: 0; right: 0;" id="count_message_notification"></span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts" style="text-align:center; overflow: auto; max-height: 400px; z-index: 9999;" id="notif_expire">
                    </ul>
                </li>


                <li class="pull-right">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!-- <li><a href="#"><is class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li> -->
                        <li class="divider"></li>
                        <li><a href="<?=ROOT_URL?>logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <li class="dropdown pull-right">
                    <a href="#" class="nav_title" style="cursor: auto;"><?=strtoupper($nav_title)?> , <b><u><?=$user_role[0]->role?></u></b></a>
                </li>
                <li class="user-separator">&nbsp;</li>

                <!-- <li class="dropdown pull-right">
                 <a href="">Semester : <b><u><?=$sem_sy['sem_sy_w']['csem']?> </u>&emsp;</b> School Year : <b><u> <?=$sem_sy['sem_sy_w']['sy2']?> </u></b></a>
                </li> -->
                
               
                
            </ul>
        </nav>

        <div id="wrapper">

        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <?php foreach ($nav as $key=>$item):?>
                <?php if(is_array($item)): ?>
                    <?php if(is_array($item[0])): ?>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle " id="pagesDropdown" role="button"  data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false"><i class="<?=$item[0][1]?> text-nav"></i> <?=$item[0][2]?> <span class="fa arrow"></span></a>
                            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                            <ul class="nav">
                                <?php  for ($i=1; $i < count($item); $i++){ ?>
                                    <li <?= $item[$i]['li']?> ><a class="dropdown-item " <?=$item[$i]['a']?> href="<?=ROOT_URL.$item[$i][0]?>"><i class="<?=$item[$i][1]?> text-nav"></i> <?=$item[$i][2]?></a></li> 
                                <?php } ?>      
                            </ul>
                        </div>
                        </li>
                    <?php else : ?>
                        <li <?= $item['li']?> class="nav-item"><a class="nav-link" <?=$item['a']?> href="<?=ROOT_URL.$item[0]?>"><i class="<?=$item[1]?> text-nav" ></i> <?=$item[2]?></a></li> 
                    <?php endif; ?>   
                <?php endif; ?>   
            <?php endforeach;?> 
        </ul>

      <div id="content-wrapper">
        <div class="container-fluid">

