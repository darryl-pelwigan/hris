<div class="modal fade" tabindex="-1" role="dialog" id="registration_verify">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Please review your details before submission</h4>
      </div>
      <div class="modal-body">
       
                        <div id="personal-infos">

                <div class="panel panel-default">
                    <div class="panel-heading " style="text-align: right;" >
                        <button id="edit-view" class="btn btn-success btn-xs"><i class="fa fa-edit"></i> Edit</button>
                        <button type="submit" id="confirm-submit" class="btn btn-success btn-xs"><i class="fa fa-angle-double-right"></i> Submit</button>
                    </div>
                    <div class="panel-body">
                        <!-- <small class="pull-right"><b>Scroll down then press the submit button to continue &#8595;</b></small> -->
                        <br style="clear:both;" />
                        <h4><b>Personal Information:</b></h4> 
                        <table class="table">
                            <tr>
                                <td><b>Name:</b></td><td><?=($info["lname"])?>, <?=($info["fname"])?> <?=($info["mname"])?>   </td>
                                <td></td><td></td>
                            </tr>
                            <tr>
                                <td><b>Birthdate:</b></td><td><?=(date("F d , Y ",strtotime($info["bdate"])))?></td>
                                <td><b>Age:</b></td><td><?=date("Y")-(date("Y ",strtotime($info["bdate"])))?></td>
                            </tr>
                            <tr>
                                <td><b>Birthplace:</b></td><td><?=($info["po_birth"])?></td>
                                <td></td><td></td>
                            </tr>
                            <tr>
                                <td><b>Phone No:</b></td><td><?=($info["phone"])?></td>
                                <td><b>Mobile No:</b></td><td><?=($info["cphone"])?></td>
                            </tr>
                            <tr>
                                <td><b>Home Address:</b></td><td colspan="3"><?=($info["p_add_p"])?>  <?=($info["p_add_sn"])?> <?=($info["p_add_db"])?>  <?=($info["p_add_cm"])?> <?=($info["p_add_pr"])?></td>
                            </tr>
                            <tr>
                                <td><b>Baguio Address:</b></td><td colspan="3"><?=($info["c_add_hn"])?> <?=($info["c_add_sn"])?> <?=($info["c_add_b"])?> <?=($info["c_add_m"])?> <?=($info["c_add_p"])?></td>
                            </tr>
                            <tr>
                                <td><b>Email Address:</b></td><td class="notrans" style="text-transform:none"><?=($info["checkemailadd"])?></td>
                                <td><b>Civil Status:</b></td><td><?=($info["cstatus"])?></td>
                            </tr>
                            <tr>
                                <td><b>Nationality:</b></td><td><?=($info["nationality"])?></td>
                                <td><b>Religion:</b></td><td><?=($info["religion"])?></td>
                            </tr>
                        </table>
                        <h4><b>Educational Background:</b></h4>    
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Level<th>School<th>Location<th>Year Graduated<th>Honor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>Elementary</b><td><?=($info["elem_educ"])?><td><?=($info["elem_educ_loc"])?><td><?=($info["elem_educ_yr"])?><td><?=($info["elem_educ_hnr"])?></td>
                                </tr>
                                <tr>
                                    <td><b>Highschool</b><td><?=($info["high_educ"])?><td><?=($info["high_educ_loc"])?><td><?=($info["high_educ_yr"])?><td><?=($info["high_educ_hnr"])?></td>
                                </tr>
                                <tr>
                                    <td><b>College</b><td><td><td><td></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        
                        <h4><b>Parent's/ Guardian's Information:</b></h4>
                        <table class="table">
                            <tr>
                                <td colspan="2"><h4>Father Information</h4></td>
                            </tr>
                            <tr>
                                <td style="width:12%"><b>Name:</b></td><td><?=($info["famBG_dad"])?></td>
                            </tr>
                            <tr>
                                <td><b>Deceased:</b></td><td><?=($info["famBGDeceased_dad"])?></td>
                            </tr>
                            <tr>
                                <td><b>Occupation:</b></td><td><?=($info["famBG_dad_occupation"])?></td>
                            </tr>
                            <tr>
                                <td><b>Tel No:</b></td><td><?=($info["famBG_dad_tel"])?></td>
                            </tr>
                            <tr>
                                <td><b>Mobile No:</b></td><td><?=($info["famBG_dad_cphone"])?></td>
                            </tr>
                        </table>

                        <hr />
                        <table class="table">
                            <tr>
                                <td colspan="2"><h4>Mother Information</h4></td>
                            </tr>
                            <tr>
                                <td style="width:12%"><b>Name:</b></td><td><?=($info["famBG_mom"])?></td>
                            </tr>
                            <tr>
                                <td><b>Deceased:</b></td><td><?=($info["famBGDeceased_mom"])?></td>
                            </tr>
                            <tr>
                                <td><b>Occupation:</b></td><td><?=($info["famBG_mom_occupation"])?></td>
                            </tr>
                            <tr>
                                <td><b>Tel No:</b></td><td><?=($info["famBG_mom_tel"])?></td>
                            </tr>
                            <tr>
                                <td><b>Mobile No:</b></td><td><?=($info["famBG_mom_cphone"])?></td>
                            </tr>
                        </table>

                        <hr />
                        <table class="table">
                            <tr>
                                <td colspan="2"><h4>Guardian Information</h4></td>
                            </tr>
                            <tr>
                                <td style="width:12%"><b>Name:</b></td><td></td>
                            </tr>
                            <tr>
                                <td><b>Address:</b></td><td></td>
                            </tr>
                            <tr>
                                <td><b>Tel No:</b></td><td></td>
                            </tr>
                            <tr>
                                <td><b>Mobile No:</b></td><td></td>
                            </tr>
                        </table>

                        <hr />
                                                <table class="table">
                            <tr>
                                <td><b>Desired Course:</b>&emsp;</td>
                            </tr>
                        </table>
                        <table>
                            <fieldset>
                                <tr><td colspan="3"><b>What are your reasons for enrolling at Pines City Colleges</b></td></tr>
                                <tr><td colspan="2"><u>&nbsp;&nbsp;&nbsp;</u> Low tuition fee</td><td>&emsp;<u>&nbsp;&nbsp;&nbsp;</u> Parent's Choice</td></tr>
                                <tr><td colspan="2"><u>&nbsp;&nbsp;&nbsp;</u> Near Home or boarding house</td><td>&emsp;<u>&nbsp;&nbsp;&nbsp;</u> Cordial and peaceful school atmosphere</td></tr>
                                <tr><td colspan="2"><u>&nbsp;&nbsp;&nbsp;</u> Provides good instruction</td><td>&nbsp;&nbsp;&nbsp;<b>Other:</b> <u></u></td></tr>

                                <tr><td><br/></td></tr>

                                <tr><td colspan="3"><b>Why did you make this choice</b></td></tr>
                                <tr><td colspan="2"><u>&nbsp;&nbsp;&nbsp;</u> Family suggestion or tradition</td><td>&emsp;<u>&nbsp;&nbsp;&nbsp;</u> Friend's or Teacher's advice</td></tr>
                                <tr><td colspan="2"><u>&nbsp;&nbsp;&nbsp;</u> Personal choice</td><td>&emsp;<u>&nbsp;&nbsp;&nbsp;</u> It is the most profitable financially</td></tr>
                                <tr><td colspan="2"><u>&nbsp;&nbsp;&nbsp;</u> It is best suited to my abilities</td><td>&nbsp;&nbsp;&nbsp;<b>Other:</b> <u></u></td></tr>
                            </fieldset>
                        </table>
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div><!-- /end Personal INFOS -->
		</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div><!-- /.modal -->