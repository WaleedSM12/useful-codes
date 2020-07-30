<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add User Type</button>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User Types</h4>
      </div>
      
      <div class="modal-body">
        <div class="form-group">
            <input class="form-control input-medium userstype" name="usertype[0]" type="text"  placeholder="User Type"/>
        </div>
        
        <div id="insertBefore"></div>
        <div class="form-group">
            <button type="button" id="btnAddMore" onclick="addMore();return false;" class="btn btn-primary">
                Add More User Types
            </button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="addUserType();">Submit</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script>

function addMore() {
    var $insertBefore = $('#insertBefore');
    var $i = $('.usertype').length;
    $('<div class="form-group"><div><input class="form-control input-medium usertype"  name="usertype[' + $i + ']" type="text"  placeholder="User Type #' + ($i + 1) + '"/></div></div>').insertBefore($insertBefore);
}
</script>