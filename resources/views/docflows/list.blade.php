<x-layout>
    <table id="table_id" class="dataTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Docflow-id</th>
                <th>Docflow-state</th>
                <th>Content-id</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($docflows as $row)
                <tr>
                    <td>{{ $row['id'] }}</td>
                    <td>{{ $row['docflow_id'] }}</td>
                    <td>{{ $row['docflow_state'] }}</td>
                    <td>{{ $row['content_id'] }}</td>
                    <td><a onClick="refreshState('{{ $row['docflow_id'] }}')" class="btn btn-info">Обновить данные</a>
                    <td><a onClick="deleteDocflowId('{{ $row['docflow_id'] }}')" class="btn btn-danger">Удалить</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </thead>
    </table>

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
                dataType: "json",
                success: function(response) {
                    alert(response.data);
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
                url: "/docflows",
                type: "GET",
                dataType: "json",
                success: function(response) {

                    $('tbody').html('')
                    $.each(response.attachment, function(key, item) {
                        $('tbody').append(`
                  <tr>
                  <td>${item['id']}</td>
                    <td>${$item['docflow_id']}</td>
                    <td>${$item['docflow_state']}</td>
                    <td><a onClick="refreshState('${item['docflow_id']}')" class="btn btn-info">Обновить данные</a> </td>
                    <td><a onClick="deleteDocflowId('${$item['docflow_id']}')" class="btn btn-danger" >Удалить</a></td>
                    <a href="('${item['docflowId']}')" class="btn btn-success">Получить файл</a>
                  </tr>`);
                    })
                }
            })
        }
    </script>
</x-layout>
