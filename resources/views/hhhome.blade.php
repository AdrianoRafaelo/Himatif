<h1>Selamat datang, {{ session('user.nama') }}</h1>
<p>Role: {{ session('user.role') }}</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
