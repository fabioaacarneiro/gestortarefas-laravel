{{-- alimentando a lista de tarefas --}}
<div hx-get="{{ route('api.tasklist.get', Auth::user()->id) }}" hx-trigger="mouseenter" hx-target="#get-lists-response">

    <label for="get-lists-response">Escolha uma lista:</label>
    <select class="form-select" id="get-lists-response" name="escolha">
    </select>
</div>
