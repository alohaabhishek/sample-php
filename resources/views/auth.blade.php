<h2>Login</h2>
<form method="POST" action="/login">
    @csrf
    <input name="email" placeholder="Email">
    <input name="password" type="password" placeholder="Password">
    <button>Login</button>
</form>

<hr>

<h2>Register</h2>
<form method="POST" action="/register">
    @csrf
    <input name="name" placeholder="Name">
    <input name="email" placeholder="Email">
    <input name="password" type="password" placeholder="Password">
    <button>Register</button>
</form>