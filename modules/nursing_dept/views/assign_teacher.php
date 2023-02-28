
<div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">View Scheduling</h1>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->
        <div id="sched-label"><span style="font-size:15px;">Sem : <b><u><?=$sem_sy['sem_sy_w']['csem']?></u></b><br>Schoolyear : <b><u><?=$sem_sy['sem_sy_w']['sy2']?></u></b></span></div>
        <table id="example" class="display" cellspacing="0" >
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Year</th>
                    <th>Section</th>
                    <th>Curriculum</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?=($tbody)?>
            </tbody>
        </table>

    </div> <!-- /#page-wrapper -->