<!DOCTYPE html>
<html>
<head>
    <title>New Post</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>New Post</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                    <div class="mb-4"><span class="error" id="error"></span></div>
                    <div class="form-group">
                        <label for="text">Текст</label>
                        <textarea class="form-control" id="text" name="text" rows="3"></textarea>
                    </div>
                    <input value="" name="hash" id="hash" hidden>
                    <button type="submit" id="button_add_new_post" class="btn btn-primary">Отправить</button>
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
        
        $("#button_add_new_post").click(function(){
            $.ajax({
                type: 'POST',
                url: '/api/spisok/add',
                data: {
                    text: text.value,
                    hash: hash.value,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    data = JSON.parse(data)
                    error.innerHTML = data['message']
                    error.style.color = data['color']
                }
            });
        });
    </script>
</html>