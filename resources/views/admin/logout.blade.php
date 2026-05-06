<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Logout</title>
    </head>
    <body>
        <form id="logout-form" method="POST" action="{{ route('filament.admin.auth.logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>

        <script>
            (function () {
                var form = document.getElementById('logout-form');
                if (!form) return;
                if (form.requestSubmit) {
                    form.requestSubmit();
                    return;
                }
                form.submit();
            })();
        </script>
    </body>
</html>
