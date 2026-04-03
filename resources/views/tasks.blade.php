<h1>Welcome {{ session('user_name') }}</h1>

<form method="POST" action="/logout">
    @csrf
    <button>Logout</button>
</form>


<form method="POST" action="/update-name/{{ session('user_id') }}">
    @csrf
    @method('PUT')
    <input name="new_name" value="{{ session('user_name') }}">
    <button>Update</button>
</form>


<hr>
<h3>Tasks</h3>
<form method="POST" action="/tasks">
    @csrf
    <input name="title">
    <button>Add</button>
</form>
<ul>
@foreach($tasks as $task)
<li>
    <form method="POST" action="/tasks/update/{{ $task->id }}">
        @csrf
        <input name="title" value="{{ $task->title }}">
        <button>Update</button>
    </form>

    <form method="POST" action="/tasks/delete/{{ $task->id }}">
        @csrf
        <button>Delete</button>
    </form>
</li>
@endforeach
</ul>