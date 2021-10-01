<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        {!! htmlScriptTagJsApi() !!}

        <title>Laravel</title>
    </head>

    <body class="bg-light">
        <div class="container">
            <main>
                <div class="py-5 text-center">
                    <h2>Ticket</h2>
                    <p class="lead">Example</p>
                </div>

                <form class="needs-validation" id="ticketForm">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>

                        <div class="col-sm-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="col-12">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>

                        <div class="col-12">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" required></textarea>
                        </div>

                        <div class="col-sm-6">
                            <label for="email" class="form-label">Password (Optional)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>

                    {!! htmlFormSnippet() !!}

                    <hr class="my-4">
            
                    <button class="w-100 btn btn-primary btn-lg" type="submit">Send</button>
                </form>
            </main>
        
            <footer class="my-5 pt-5 text-muted text-center text-small">
                <p class="mb-1">Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
            </footer>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

        <script>
            async function submit(body) {
                let response = await fetch('/api/ticket', {
                    method: 'post',
                    body: body,
                    headers: { 'Accept': 'application/json' }
                });
                let data = await response.json();

                if (response.ok) {
                    alert(data.message || 'Success');
                } else if (data && data.message) {
                    alert(data.message);
                } else {
                    alert('Error');
                }
            }

            document.getElementById("ticketForm")
                .addEventListener("submit", (e) => {
                    e.preventDefault();
                    submit(new URLSearchParams(new FormData(e.target)));
                });
        </script>
    </body>
</html>