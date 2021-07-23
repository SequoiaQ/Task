<html>
<head>
  
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <title>Task</title>
</head>
<body>





    
<table id="table_id" class="dataTable">
    <thead>
        <tr>
            <th>ID</th> 
            <th>File name</th>
            <th>Local path</th>
        </tr>

      @foreach ($attachment as $row)
          <tr>
            <td>{{$row['id']}}</td>
            <td>{{$row['filename']}}</td>
            <td>{{$row['local_path']}}</td>
          </tr>
          @endforeach

    </thead>
    <tbody>
        <tr>
            <td>Row 1 Data 1</td>
            <td>Row 1 Data 2</td>
        </tr>
        <tr>
            <td>Row 2 Data 1</td>
            <td>Row 2 Data 2</td>
        </tr>
    </tbody>
</table>



        <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Send file
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sending</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="container mt-5">
            <form action="{{route('fileUpload')}}" method="post" id="fileUpload" enctype="multipart/form-data">
              <h3 class="text-center mb-5">Upload Files</h3>
                @csrf
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <strong>{{ $message }}</strong>
                </div>
              @endif

              @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
    
          <input name="name" class="form-control" placeholder="Название файла">
    
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="chooseFile">
                    <label class="custom-file-label" for="chooseFile">Select file</label>
                </div>
    
                <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                    Upload File
                </button>
            </form>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script type="text/javascript">

const myUploadForm = document.getElementById('fileUpload')

$.ajaxSetup({
   headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
});

const myModal = new bootstrap.Modal(document.getElementById('exampleModal'))
    
    $('#fileUpload').on('submit',function(e){
            e.preventDefault();
    
            const formData = new FormData(this);
            console.log(formData.keys());

            $.ajax({
                processData: false,
                contentType: false,
              url: "/upload-file",
              type:"POST",
              data: formData,
              success:function(response){
                alert(response);
              },
              });
     myModal.hide();
            });
          </script>
</body>
</html>
