@extends('layouts.base')

@section('title', 'Commit solution')

@section('content')
    <div>
        <form
                id="loginForm"
                {{--                method="POST"--}}
                {{--                action="{{ route('solution.commit', ['problem' => $problems[0]->id]) }}"--}}
                {{--                name="data"--}}
        >
            @csrf

            <label for="email">
                E-mail
            </label>
            <input type="email" id="email" name="email">

            <label for="password">
                Password
            </label>
            <input type="password" id="password" name="password">

            <hr>

            <button id="submit" type="submit">Wyślij</button>
        </form>
    </div>
    <script>
        const _form = document.getElementById('loginForm')

        _form.onsubmit = async (e) => {
            e.preventDefault()

            const action = "{{ route('login') }}"
            const formData = new FormData(_form)
            const jsonData = JSON.stringify(Object.fromEntries(formData))

            const response = await fetch(action, {
                method: 'POST',
                body: jsonData,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();

            console.log(result.token);

            if (result.token) {
                window.localStorage.setItem('API_TOKEN', result.token)
            }
        };
    </script>
@stop