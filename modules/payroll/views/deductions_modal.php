<div id="updateDeduction" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Deduction/Allowance</h4>
      </div>
          <form method="POST" action='' name='update_deduction'>
              <div class="modal-body">
                <label>Description:</label>
                <input class="form-control" type='text' name='update_description' required/>
                <label>Type:</label>
                <select class="form-control" name='type' id='update_types'>
                  <option value='0'>Deduction</option>
                  <option value='1'>Allowance</option>
                </select>
                <label>Amount:</label>
                <input class="form-control" type='text' name='update_amount' required/>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-success" value='Update'>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
          </form>

    </div>

  </div>
</div>