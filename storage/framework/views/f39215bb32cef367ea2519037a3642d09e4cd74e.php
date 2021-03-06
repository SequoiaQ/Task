<html>
<head>
  
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
  <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    
    <title>Task</title>
</head>
<body>


  <table id="table_id" class="dataTable" >
    <thead>
        <tr>
          <th>ID</th> 
          <th>File name</th>
          <th>Local path</th>
          <th>Save</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
    </thead>
  <tbody>
    <?php $__currentLoopData = $attachment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td><?php echo e($row['id']); ?></td>
        <td><?php echo e($row['filename']); ?></td>
        <td><?php echo e($row['local_path']); ?></td>
        <td><a download="/storage/<?php echo e($row['local_path']); ?>" href="/storage/<?php echo e($row['local_path']); ?>" class="btn btn-primary" >Save</a></td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>  
</table>

    <!-- Sending modal-->

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendingModal">Send file</button>

<div class="modal fade" id="sendingModal" tabindex="-1" aria-labelledby="sendingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sendingModalLabel">Sending</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

<div class="container mt-5">
  <form action="<?php echo e(route('fileUpload')); ?>" method="post" id="fileUpload" enctype="multipart/form-data">
    <h3 class="text-center mb-5">Upload Files</h3>
      <?php echo csrf_field(); ?>
        <?php if($message = Session::get('success')): ?>
          <div class="alert alert-success">
            <strong><?php echo e($message); ?></strong>
          </div>
        <?php endif; ?>


        <?php if(count($errors) > 0): ?>
          <div class="alert alert-danger">
            <ul>
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        <?php endif; ?>

    
<input name="name" class="form-control" placeholder="???????????????? ??????????">
  <div class="custom-file">
<input type="file" name="file" class="custom-file-input" id="chooseFile">
    <label class="custom-file-label" for="chooseFile">Select file</label>
  </div>
      <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">Upload File</button>
  </form>
            
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>

      </div>
    </div>
  </div>
  <!-- End of sending modal -->

      <!-- Edit modal-->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


  <ul id="updateform_errList"></ul>

<input type="text" id="edit_file_name">

  <div class="form-group mb-3">
    <label for="">Name</label>
      <input type="text" id="edit_name"class="name form-control" placeholder="???????????????? ??????????">
      
    </div>
  <!--<div class="form-group mb-3">
    <label for="">Date</label>
      <input type="text" id="edit_date" class="date form-control" placeholder="????????">
  </div>
  <div class="form-group mb-3">
    <label for="">Description</label>
      <input type="text" id="edit_description" class="description form-control" placeholder="????????????????">
    </form>
  </div> -->
  <div class="modal-footer">
      <button type="button" class="btn btn-primary btn-block mt-4 update_file">Update</button>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
  </div>
      </div>
    </div>
  </div>

    <!-- End of edit modal-->

      <!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
  integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
  integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
  crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
      <!-- End of sscripts section-->


      <!-- Ajax scripts -->

<script type="text/javascript">


    //Fetching Table

  function fetchingTable() {
    $.ajax({
        processData: false,
        contentType: false,
        url: "/fetchingTable",
        type: "GET",
        dataType: "json",
        success: function (response) {
          console.log(response)
            //console.log(response.attachment);
            $('tbody').html('')
            $.each(response.attachment, function (key, item) {
              $('tbody').append(`
                <tr>
                  <td>${item.id}</td>
                  <td><a href="/storage/${item.local_path}" download="/storage/${item.local_path}">${item.filename}</a></td>
                  <td>${item.local_path}</td>
                  <td><a href="/storage/${item.local_path}" download="/storage/${item.local_path}" class="btn btn-primary">Save</a></td>
                  <td><button type="button" value="${item.id}" class="edit_files btn btn-primary">Edit</button></td>
                </tr>`);
            })
        }
    })
  }


    //Files uploading

  const myModal = new bootstrap.Modal(document.getElementById('sendingModal'))

    $('#fileUpload').on('submit', function (e) {
      e.preventDefault();

        const formData = new FormData(this);
        console.log(formData.keys());

    $.ajax({
        processData: false,
        contentType: false,
        url: "/upload-file",
        type: "POST",
        data: formData,
        success: function (response) {
          alert(response);
          fetchingTable()
          },
      });
      myModal.hide();
  });

window.onload = () => {
  fetchingTable();
}

$(document).on('click', '.edit_files', function(e){
        e.preventDefault();
        var id = $(this).val();
        console.log(id);
        $('#editModal').modal('show');
        $.ajax({
        type: "GET",
        url: "/edit-files"+id,
        success: function (response) {
        }
      });
    });



</script>
</body>

</html>
</body>
</html>
<?php /**PATH /home/sequoia/Desktop/Task/resources/views/auth/login.blade.php ENDPATH**/ ?>