<?=$cs['table']['table']?>


<input type="hidden" name="transmutation" id="transmutation_json" value="" />


    <div class="modal fade" id="classStandingModalEditCats" tabindex="-1" role="dialog" aria-labelledby="classStandingModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="classStandingModalLabel">Edit Category CS</h4>
                </div>
                <form action="#" class="form-horizontal" id="updateCScats" target="_blank">
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
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" id="edit_cs_cats" onclick="" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <div class="modal fade" id="classStandingModalDelCats" tabindex="-1" role="dialog" aria-labelledby="classStandingModalDelCatsLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-header-lightg">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="classStandingModalDelCatsLabel">Delete Category CS</h4>
                </div>
                   <form action="#" class="form-horizontal" id="deleteCScats" target="_blank">
                          <div class="modal-body ">
                                  <div class="alert alert-warning" role="alert">  <h3 id="delete_message">Are you sure you want to delete  this Category and all of its Sub-category and items?</h3>
                               </div>
                            </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="button" id="delete_cs_cats" onclick="" class="btn btn-success">Delete</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
<?php
$this->load->view($get_plugins_js);