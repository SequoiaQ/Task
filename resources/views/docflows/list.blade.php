<x-layout>
    <table id="table_id" class="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cadastal-number</th>
                <th>Docflow-id</th>
                <th>Docflow-state</th>
                <th>Download</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($docflows as $row)
                <tr>
                    <td>{{ $row['id'] }}</td>
                    <td>{{ $row['cadastral_number'] }}</td>
                    <td>{{ $row['docflow_id'] }}</td>
                    <td>{{ $row['docflow_state'] }}</td>
                    <td>{{ $row['is_downloaded'] }}</td>
                    <td>
                        <a onClick="refreshState('{{ $row['docflow_id'] }}')" class="btn btn-info">Обновить данные</a>
                        <a onClick="deleteDocflowId('{{ $row['id'] }}')" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cadastrModal">
        Загрузить файл
    </button>
    <div class="modal fade" id="cadastrModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="container mt-5">
                    <form action="{{ route('insertDocflow') }}" method="post" id="docflows"
                        enctype="multipart/form-data">
                        <h3 class="text-center mb-5">Введите кадастровый номер: </h3>
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
                        {{-- @if
                            {
                                
                            }
                        @endif --}}
                        <input name="cadastralNumber" class="form-control" placeholder="XX:XX:XXXXXX:XX">

                       

                        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                            <td>Отправить</td>
                        </button>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <a href="/doclflowCreate" class="btn btn-success">Создать новый документооборот</a>

    {{-- Документ по определенному docflowId --}}
    <a href="docflowid" class="btn btn-success">Получить документ</a>


    <x-scripts></x-scripts>

    <script>
        window.onload = function() {
            fetchingTable();
        }

        function refreshState(docflowId) {
            $.ajax({
                processData: false,
                contentType: false,
                url: `/refreshDocflow/${docflowId}`,
                type: "GET",    
                success: function(response) {
                    fetchingTable();
                }
            })
        }

        function deleteDocflowId(docflowId) {
            if (!confirm('Вы действительно хотите удалить файл?')) {
                return;
            }
            $.ajax({
                url: `/docflows/${docflowId}`,
                type: "DELETE",
                success: (response) => {
                    alert(response)
                    fetchingTable()
                }
            })
        }

        function fetchingTable() {
            $.ajax({
                processData: false,
                contentType: false,
                url: "/docflowsJson",
                type: "GET",
                success: function(response) {
                    $('tbody').html('')
                    $.each(response, function(key, item) {
                        // Кнопка для скачки (если файл скачан)
                        let downloadButton = 'Файл не скачан' 
                        if (item['is_downloaded'] === 1) {
                            downloadButton = `<a href="/storage/${item['filename']}">Скачать архив</a>`
                        }
                        $('tbody').append(`
                  <tr>
                    
                    <td>${item['id']}</td>
                    <td>${item['cadastral_number']}</td>
                    <td>${item['docflow_id']}</td>
                    <td>${item['docflow_state']}</td>
                    <td>${downloadButton}</td>
                    <td>
                        <a onClick="refreshState('${item['docflow_id']}')" class="btn btn-info">Обновить данные</a>
                        <a onClick="deleteDocflowId('${item['id']}')" class="btn btn-danger" >Удалить</a>
                    </td>
                    <a href="('${item['docflowId']}')" class="btn btn-success">Получить файл</a>
                  </tr>`);
                    })
                }
            })
        }
    </script>
    
</x-layout>
