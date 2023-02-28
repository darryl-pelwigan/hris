<?=$cs['table']['table']?>
    <!-- modal for create new-->
    <div class="modal fade" id="classStandingModalAdd" tabindex="-1" role="dialog" aria-labelledby="classStandingModalAddLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="enrollListModalLabel">CREATE NEW Class Standing <?= $cs['type_d'][0] ?></h4>
                </div>
                <form action="#" class="form-horizontal" id="updateCS" target="_blank">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="cs_c_desc" placeholder="Description" />
                            </div>
                        </div>
                        <div class="form-group">
                            <?php $total_cs_prcnt=($cs['table']['total_cs_prcnt']!=0)?($cs['table']['total_cs_prcnt']*.1)/0.5:0; ?>
                            <label class="control-label col-md-3">Percent</label>
                            <div class="col-md-8">
                                <select class="form-control lea" id="cs_c_prcnt">
                                       <option value="default">PERCENT</option>
                                            <?php
                                                for($x=1;$x<=(20-($total_cs_prcnt));$x++){
                                                        $gt=$x*5;
                                                    echo "<option value='". $gt."'>". $gt ."</option> ";
                                                }
                                             ?>
                                          </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">For</label>
                            <div class="col-md-8">
                                <select class="form-control" id="cs_c_type">
                                        <?php
                                            echo '<option value="'.$cs['type_d'][6] .'">'.$cs['type_d'][7].' '.$cs['type_d'][0].'</option>';
                                        ?>
                                        </select>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" data-modal-id="classStandingModalAdd">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="classStandingModalAddButton" onclick="" class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<div class="test">
    test test    test test    test test
</div>



    <div class="modal fade" id="classStandingModalEdit" tabindex="-1" role="dialog" aria-labelledby="classStandingModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="enrollListModalLabel">Edit Class Standing</h4>
                </div>
                <form action="#" class="form-horizontal" id="updateCS" target="_blank">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Description</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="cs_e_desc" placeholder="" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Percent</label>
                            <div class="col-md-8">
                                <select class="form-control lea" id="cs_e_prcnt">
                                 <option value="default">PERCENT</option>
                                      <?php
                                          for($x=1;$x<=(20);$x++){
                                                  $gt=$x*5;
                                              echo "<option value='". $gt."'>". $gt ."</option> ";
                                          }
                                       ?>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="edit_cs" onclick="" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- Start View CS edit CS-->
    <div class="modal fade" id="classStandingModalViewCsItems" tabindex="-1" role="dialog" aria-labelledby="classStandingModalLabel">
        <div class="modal-dialog modal-dialog-lg" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="classStandingModalViewCsItemsLabel">View <span></span> Items</h4>
                </div>
                <br />
                <button id="AddCsItems" onclick='' type='button' class='btn btn-warning btn-xs'> ADD NEW <span></span></button>
                <br />
                <div id="cs_list"></div>
            </div>
        </div>
    </div>


     <div class="modal fade" id="classStandingModalEditCsItems" tabindex="-1" role="dialog" aria-labelledby="classStandingModalLabel">
        <div class="modal-dialog modal-dialog-lg" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="classStandingModalEditCsItemsLabel">Edit CS Item  "<span></span>"</h4>
                </div>
                 <form action="#" class="form-horizontal" id="editCsItems" target="_blank">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="cs_editcs_title" placeholder="Title" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Items</label>
                            <div class="col-md-2">
                                <select class="form-control lea" id="cs_editcs_items">

                               </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="editcsitems_cs" onclick="" class="btn btn-success">Update</button>

                    </div>
                 </form>

            </div>
        </div>
    </div>

<!-- End View CS edit CS-->

    <div class="modal fade" id="classStandingModalAddCsItems" tabindex="-1" role="dialog" aria-labelledby="classStandingModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="classStandingModalAddCsItemsLabel">Add <span></span> </h4>
                </div>
                <form action="#" class="form-horizontal" id="addCsItems" target="_blank">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="cs_addcs_title" placeholder="Title" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Items</label>
                            <div class="col-md-2">
                                <select class="form-control lea" id="cs_addcs_items">
                                 <option value="default">Items</option>
                                      <?php
                                          for($x=1;$x<=(40);$x++){
                                                  $gt=$x*5;
                                                      echo "<option value='". $gt."'>". $gt ."</option> ";


                                          }
                                       ?>
                               </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="addcsitems_cs" onclick="" class="btn btn-success">Create</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Use Cs Template Start-->

    <div class="modal fade" id="classStandingModalCStemplate" tabindex="-1" role="dialog" aria-labelledby="classStandingModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="classStandingModalAddCsItemsLabel">This will auto create CS "CATEGORY" </h4>
                </div>
                <form action="#" class="form-horizontal" id="useCsTemplate" target="_blank">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title</label>
                            <div class="col-md-8" id="cs_template_title">
                             <span></span>
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="control-label col-md-3">Content</label>
                             <div class="col-md-8" id="cs_template">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="use_cs_template" onclick="" class="btn btn-success">USE TEMPLATE</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- Use Cs Template End-->

         <!-- Create Cs Template Start-->

    <div class="modal fade" id="classStandingModalcreateCStemplate" tabindex="-1" role="dialog" aria-labelledby="classStandingModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="classStandingModalAddCsItemsLabel">Create A CS Template For you College </h4>
                </div>
                <form action="#" class="form-horizontal" id="createCsTemplate" target="_blank">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Title</label>
                            <div class="col-md-8" id="cs_template_title">
                                <input type="text" class="form-control" id="cs_createcstemplate_title" placeholder="Title" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                        <label class="control-label col-md-3">Content</label>
                             <div class="col-md-9" id="cs_template">
                                    <table class="table table-bordered" id="createCsTemplateTable">
                                        <thead><tr><th>Description</th><th>Percent</th><th>ADD</th></tr></thead>
                                        <tbody>
                                                <tr>
                                                <td><input type="text" value="" id="desc_0" /></td>
                                                <td>
                                                    <select class="form-control lea" id="prcnt_0">
                                                         <option value="default">PERCENT</option>
                                                              <?php
                                                                  for($x=1;$x<=(20);$x++){
                                                                          $gt=$x*5;
                                                                      echo "<option value='". $gt."'>". $gt ."</option> ";
                                                                  }
                                                               ?>
                                                    </select>
                                                </td>
                                                <td><button type="button" class="btn btn-success btn-xs" id="tpl_more"><i class="fa fa-plus"></i></button></td>
                                                </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="create_cs_template" onclick="$(this).createCsTemplatesend();" class="btn btn-success">CREATE TEMPLATE</button>

                    </div>
                </form>
            </div>
        </div>
    </div>


        <!-- Create Cs Template End-->

    <?php
$this->load->view($get_plugins_js);