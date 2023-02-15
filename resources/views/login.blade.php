<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Авторизация</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

    </head>
    <body>
        <center>
            
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading mb-4 mt-4">
                        <h3 class="panel-title">Авторизация</h3>
                    </div>
                    <div class="panel-body">
                        <div class="mb-4"><span class="error text-danger" id="error"></span></div>
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control mb-4" id="login" placeholder="Логин" name="login" type="text" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control mb-4" id="password" placeholder="Пароль" name="password" type="password" value="">
                            </div>
                            <input id="button_entrance" class="btn btn-lg btn-success btn-block" style="width: 100%" type="submit" value="Войти">
                        </fieldset>
                    </div>
                </div>
            </div>
        </center>
    <script type="text/javascript">
        
        $("#button_entrance").click(function(){
            $.ajax({
                type: 'POST',
                url: '/api/user/login',
                data: {
                    login: login.value,
                    password: password.value,
                    "_token": "{{ csrf_token() }}",
                },

                success: function(data) {
                    data = JSON.parse(data)
                    if (data['message'] != "Successfully") 
                    {
                        error.innerHTML = data['message']
                    }
                    else
                    {
                        document.cookie = "hash_login=" ; 
                        document.cookie = "hash_login="+ data['cookieID'] + "; path=/; expires=Tue, 19 Jan 2038 03:14:07 GMT"
                        document.location.href = "/panel/"
                    }
                }
            });
        });
    </script>
    </body>
</html>
