<x-layout>
    <table id="table_id" class="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>File name</th>
                <th>Local path</th>
                <th>Options</th>
                <th>Status</th>
                <th>Save</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attachment as $row)
                <tr>
                    <td>{{ $row['id'] }}</td>
                    <td>{{ $row['filename'] }}</td>
                    <td>{{ $row['local_path'] }}</td>
                    <td> </td>
                    <td><a download="/storage/{{ $row['local_path'] }}" href="/storage/{{ $row['local_path'] }}"
                            class="btn btn-primary">Save</a>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
        Загрузить файл
    </button>
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sending</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="container mt-5">
                    <form action="{{ route('fileUpload') }}" method="post" id="fileUpload"
                        enctype="multipart/form-data">
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
                            Upload File <td></td>
                        </button>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="updateModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Обновление файла</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input id="updateFormFileName" name="name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="saveUpdate">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
    <x-scripts></x-scripts>
    <script>
        const uploadForm = document.getElementById('uploadModal')
        const uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'))
        const updateModal = new bootstrap.Modal(document.getElementById('updateModal'))

        // Функция вызывается при нажатии на кнопку Изменить
        function openUpdateModal(id, filename) {
            updateModal.show()
            // Вставим имя файла в поле в форме

            // DOM-элемент поля в форме
            const updateFormFilenameField = document.getElementById('updateFormFileName')
            updateFormFilenameField.value = filename

            // Достать кнопку сохранения
            const updateSaveButton = document.getElementById('saveUpdate')
            // Повешать обработчик обновления новый
            updateSaveButton.onclick = function() {
                update(id)
            }
        }

        function deleteFile(id) {
            if (!confirm('Вы действительно хотите удалить файл?')) {
                return;
            }
            $.ajax({
                url: `/${id}`,
                type: "DELETE",
                success: (response) => {
                    alert(response)
                    fetchingTable()
                }
            })
        }

        function update(id) {
            // Новое имя файла
            const newFileName = document.getElementById('updateFormFileName').value

            $.ajax({
                url: `/${id}`,
                type: 'PATCH',
                data: {
                    name: newFileName,
                },
                success: (response) => {
                    alert(response)
                    // Скрыть модаль редактирования
                    updateModal.hide();
                    // Перефетчить данные
                    fetchingTable()
                }
            })
        }



        function fetchingTable() {
            $.ajax({
                processData: false,
                contentType: false,
                url: "/list",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    $('tbody').html('')
                    $.each(response.attachment, function(key, item) {
                        $('tbody').append(`
                  <tr>
                    <td>${item.id}</td>
                    <td><a href="/storage/${item.local_path}" download="/storage/${item.local_path}">${item.filename}</a></td>
                    <td>${item.local_path}</td>
                    <td>
                        <button class="btn btn-info" onClick="openUpdateModal(${item.id},'${item.filename}')" >Изменить</button>
                        <button class="btn btn-danger" onClick="deleteFile(${item.id})">Удалить</button>
                    </td>
                    <td></td>
                    <td><a href="/storage/${item.local_path}" download="/storage/${item.local_path}" class="btn btn-primary" >save</a></td>
                  </tr>`);
                    })
                }
            })
        }


        $('#fileUpload').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            $.ajax({
                processData: false,
                contentType: false,
                url: "/upload-file",
                type: "POST",
                data: formData,
                success: function(response) {
                    alert(response);
                    fetchingTable()
                },
            });
            uploadModal.hide();
        });



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        window.onload = () => {
            fetchingTable();
        }
    </script>
</x-layout>
