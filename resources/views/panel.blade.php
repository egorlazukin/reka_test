<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
    <div class="mb-4 mt-4 container">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group mb-3">
                    <input type="text" id="search" class="form-control" oninput="Sears()" oncut="Sears()" oncopy="Sears()", onpaste="Sears()" onchange="Sears()" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon2">
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 170px;">Photo</th>
                            <th>Текст</th>
                            <th>Теги</th>
                            <th>Дата</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <input value="" name="hash" id="hash" hidden>
</body>
<script type="text/javascript">
    document.cookie.split(';').forEach(function(item) {
        if (item.indexOf('hash_login') !== -1) {
            hash.value = item.split('=')[1];
        }
    });
    function AddAll()
    {
        $.ajax({
            type: 'POST',
            url: '/api/spisok/list/',
            data: {
                hash: hash.value,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {
                tbody.innerHTML = "";
                data = JSON.parse(data)
                data.forEach(function(DataObj){
                    var tags = "";
                    if (DataObj['item_tags'][0] != undefined) 
                    {

                        DataObj['item_tags'].forEach(function(tagsObj){
                            tags += tagsObj['tags'] + " "
                        });
                    }
                    var obj_item = DataObj['item'];
                    
                    AddNew(obj_item['id'],obj_item['photo'], obj_item['Text'], tags, obj_item['created_at'])
                });
            }
        });
    }
    AddAll();
    function AddNew(id, url_photo, text, tags, date)
    {    
        //photo
        let newtr = document.createElement('tr');
        tbody.appendChild(newtr);

        let newTD = document.createElement('td');
        newTD.innerHTML = '<a target="_blank" href="'+url_photo+'"><img src="'+url_photo+'" alt=""></a><br><a href="update/' + id + '"><img width="25" src="https://mywebicons.ru/i/jpg/cdeb1a882520e8a7e8f713c51a4f45a1.jpg">редактировать</a>';
        newtr.appendChild(newTD);
        //Text
        newTD = document.createElement('td');
        newTD.innerHTML = text;
        newtr.appendChild(newTD);
        //tags
        newTD = document.createElement('td');
        newTD.innerHTML = tags;
        newtr.appendChild(newTD);
        //date
        newTD = document.createElement('td');
        newTD.innerHTML = date;
        newtr.appendChild(newTD);
    }

    function Sears(){
        if (search.value == "") 
        {
            tbody.innerHTML = "";
            return AddAll();
        }
        tbody.innerHTML = "";
        search.value.split(' ').forEach(function(search_text){
            if (search_text == "") 
            {
                return;
            }
            $.ajax({
                type: 'POST',
                url: '/api/spisok/search/tags/',
                data: {
                    hash: hash.value,
                    tags: search_text,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    data = JSON.parse(data)
                    console.log(data);
                    data.forEach(function(DataObj){
                        var tags = "";
                        if (DataObj['item_tags'][0] != undefined) 
                        {

                            DataObj['item_tags'].forEach(function(tagsObj){
                                tags += tagsObj['tags'] + " "
                            });
                        }
                        var obj_item = DataObj['item'];
                        
                        AddNew(obj_item['id'], obj_item['photo'], obj_item['Text'], tags, obj_item['created_at'])
                    });
                }
            });
        });
        
    }
</script>
</html>