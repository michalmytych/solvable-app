@extends('layouts.base')

@section('title', 'Commit solution')

@section('content')
    <div>
        <form
                id="commitForm"
                {{--                method="POST"--}}
                {{--                action="{{ route('solution.commit', ['problem' => $problems[0]->id]) }}"--}}
                {{--                name="data"--}}
        >
            @csrf

            <label for="problem_id">Select problem</label>
            <select id="problem_id" name="problem_id">
                @foreach($problems as $problem)
                    <option value="{{ $problem->id }}">{{ $problem->title }}</option>
                @endforeach
            </select>

            <hr>

            <label for="code">Upload file</label>
            <input id="code" name="code" type="file">

            <hr>

            <label for="code_language_id">Select coding language</label>
            <select id="code_language_id" name="code_language_id">
                @foreach($languages as $language)
                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                @endforeach
            </select>

            <hr>

            <button id="submit" type="submit">Wyślij</button>
        </form>
        <div id="dataDisplay"></div>
    </div>
    <script>
        const commitForm = document.getElementById('commitForm')

        /** HELPERS **/
        const toBase64 = file => new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = error => reject(error);
        });
        const view = (data, variant = 'neutral', _id = 'dataDisplay') => {
            const dataDisplay = document.getElementById(_id)
            dataDisplay.innerHTML = data
            if (variant === 'danger') {
                dataDisplay.style.color = 'red'
            }
        }

        commitForm.onsubmit = async (e) => {
            e.preventDefault();

            const action = "{{ route('solution.commit', ['problem' => $problems[0]->id]) }}"
            const formData = new FormData(commitForm)
            let tmpObject = {data: Object.fromEntries(formData)}
            tmpObject.data.code = await toBase64(tmpObject.data.code)
            console.log(tmpObject.data.code)
            const jsonData = JSON.stringify(tmpObject)

            const response = await fetch(action, {
                method: 'POST',
                body: jsonData,
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + window.localStorage.getItem('API_TOKEN')
                }
            });

            const result = await response.json();

            view(result.errors.errors.join(','), 'danger');
        };
    </script>
@stop