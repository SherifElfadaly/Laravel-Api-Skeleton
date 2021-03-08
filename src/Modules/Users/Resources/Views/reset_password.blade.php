<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}} Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .loader {
            position: relative;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 70px;
            height: 70px;
            left: 50%;
            top: 50%;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        #overlay {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background: black;
            opacity: .5;
        }

        .container {
            position: relative;
            height: 300px;
            width: 200px;
            border: 1px solid
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="text-center" style="background-color: #fafcfd;">
    <div id="overlay" style="display: none;">
        <div class="loader"></div>
    </div>
    
    <div class="container-fluid">
        <div class="d-flex justify-content-center" style="height: 150px">
            <a href="{{ config('core.web_url') }}"><img src="{{ url('logo.png') }}" alt="Logo" width="150px"></a>
        </div>
        <div class="d-flex justify-content-center">
            <form id="reset_form">
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password Confirmation" required>
                </div>
                <button type="submit" class="btn btn-primary" onclick="resetPassword(event)">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js" integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ==" crossorigin="anonymous"></script>
    <script>
        function resetPassword(e) {
            $('#overlay').show();
            e.preventDefault();
            
            axios({
                method: 'post',
                url: '{{ url('api/users/account/reset/password') }}',
                data: {
                    token: '{{ $reset_token }}',
                    email: $('#email').val(),
                    password: $('#password').val(),
                    password_confirmation: $('#password_confirmation').val(),
                }
            }).then(function(response) {
                $('#overlay').hide();
                alert('Password changed');
                window.location.href = '{{ config('core.web_url') }}'
            }).catch(function(error) {
                $('#overlay').hide();
                alert(error.response.data.message);
            });
        }
    </script>

</html>