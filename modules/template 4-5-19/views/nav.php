<body>


    <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            <a class="navbar-brand" href="#"><img src="<?=base_url('assets/images/logo.png')?>" style="width:25px;"> Pines City Colleges</a>

        <ul class="nav navbar-top-links navbar-right">

            <li class="toUppercase"><?=strtoupper($nav_title)?> , <b><u><?=$user_role[0]->role?></u></b></li>

            <li class="user-separator">&nbsp;</li>
            <li style="color:#006600;"><br/>Semester : <b><u><?=$sem_sy['sem_sy_w']['csem']?> </u>&emsp;</b> School Year : <b><u> <?=$sem_sy['sem_sy_w']['sy2']?> </u></b></li>
        </ul>
        <!-- /.navbar-top-links -->

        </div>
    </nav>

    <div class="navbar navbar-default navbar-fixed-top second-navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-nav">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
            </div>
            <div class="collapse navbar-collapse main-nav">
            <div class="col-md-10">
                <ul class="nav navbar-nav">
                    <?php foreach ($nav as $item):?>
                        <li <?=$item['li']?> ><a <?=$item['a']?> href="<?=ROOT_URL.$item[0]?>"><i class="<?=$item[1]?>"></i> <?=$item[2]?></a></li>
                   <?php endforeach;?>
                   <?php if($this->session->userdata('role')==8 ){ ?>
                   <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-calendar"></i> Request<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=ROOT_URL?>teacherOvertime.php"><i class="glyphicon glyphicon-time"></i> Overtime Form</a></li>
                            <li><a href="<?=ROOT_URL?>passslip.php"><i class="glyphicon glyphicon-list-alt"></i> Pass Slip</a></li>
                            <li><a href="<?=ROOT_URL?>teachertravel.php"><i class="glyphicon glyphicon-plane"></i> Travel Form</a></li>
                            <li><a href="<?=ROOT_URL?>teacherLeave.php"><i class="glyphicon glyphicon-road"></i> Leave Form</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
                </div>

            <div class="col-md-2">
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown" id='notification'>
                        <img src="<?=base_url()?>assets/images/ajax-loader.gif" id="notify-loader" style="width:20px;" />
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?=ROOT_URL?>pcc_manual.php"><i class="fa fa-question-circle fa-fw"></i> Online Support</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=ROOT_URL?>change.php?lid=925d1b50cf96fe5447879b4b57ef57c168e4fc34"><i class="fa fa-gear fa-fw"></i> Change Password</a></li>
                            <li class="divider"></li>
                                <li><a href="<?=ROOT_URL?>modules/employees/<?=$_SESSION['fileno']?>"><i class=" glyphicon glyphicon-user"></i> My Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="<?=base_url('admin/logout/')?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                </div>
                <!-- /.navbar-top-links -->
            </div>
        </div>
        <!-- /.sidebar-collapse -->

    </div>
    <!-- /.navbar-static-side -->
