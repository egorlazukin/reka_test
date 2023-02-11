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
                    <input type="text" class="form-control" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon2">
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 170px;">Photo</th>
                            <th>Text</th>
                            <th>Tags</th>
                            <th>Date</th>
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

    $.ajax({
        type: 'POST',
        url: '/api/spisok/list/',
        data: {
            hash: hash.value,
            "_token": "{{ csrf_token() }}",
        },
        success: function(data) {

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
                
                AddNew(obj_item['photo'], obj_item['Text'], tags, obj_item['created_at'])
            });
        }
    });
    function AddNew(url_photo, text, tags, date)
    {    
        //photo
        let newtr = document.createElement('tr');
        tbody.appendChild(newtr);

        let newTD = document.createElement('td');
        newTD.innerHTML = '<img src="'+url_photo+'" alt="">';
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

</script>
</html>