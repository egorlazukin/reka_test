<!DOCTYPE html>
<html>
<head>
    <title>Update Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Update Post</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                    <form id="upload-photo" action="/upload-photo" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="photo-qw" name="photo" />
                        <input hidden type="submit" id="buttonHidd" value="Upload Photo" />
                    </form>

                    <div id="photo-container"></div>
                    <div class="form-group mb-4 mt-4">
                        <label for="text">Текст</label>
                        <textarea class="form-control" id="text" name="text" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="text">Теги</label>
                        <textarea class="form-control" id="tags" name="tags" rows="3"></textarea>
                    </div>
                    <input value="" name="hash" id="hash" hidden>
                    <input value="" name="id_tovar" id="id_tovar" hidden>
                    <button type="submit" id="button_add_update_post" class="btn btn-primary">Отправить</button>

            </div>
        </div>
    </div>
</body>
   <script type="text/javascript">
        document.cookie.split(';').forEach(function(item) {
          if (item.indexOf('hash_login') !== -1) {
            hash.value = item.split('=')[1];
          }
        });
        id_tovar.value = window.location.href.split('/').pop();
        
        $("#button_add_update_post").click(function(){
            $.ajax({
                type: 'PUT',
                url: '/api/spisok/update/'+id_tovar.value,
                data: {
                    text: text.value,
                    tags: tags.value,
                    hash: hash.value,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    console.log(data) 
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#photo-qw').on('change', function(e){
                buttonHidd.click()
            });
        });

        $(document).ready(function(){
            $('#upload-photo').on('submit', function(e){
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type:'POST',
                    url: '/api/upload-photo/',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        $('#photo-container').append('<img src="'+data.photo_url+'" />');
                        sender(data.photo_url);

                    },
                    error: function(data){
                        console.log("error");
                        console.log(data);
                    }
                });
            });
        });
        function sender(photo_url)
        {
            $.ajax({
                    type:'GET',
                    url: '/api/upload-photo/' + id_tovar.value,
                    data: {
                        photo_url: photo_url,
                        hash: hash.value,
                        "_token": "{{ csrf_token() }}",
                    },
                    success:function(data){
                    },
                });
        }
    </script>
</html>