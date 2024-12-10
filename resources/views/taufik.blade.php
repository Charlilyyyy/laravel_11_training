@extends('layouts.taufik')
@section('content')


<div>
    Name: {{ $users[0]->name }}
</div>
<div>
    Email: {{ $users[0]->email }}
</div>

@foreach ($users as $user)
    <div>
        <div>
            Name: {{ $user->name }}
        </div>
        <div>
            Email: {{ $user->email }}
        </div>
    </div>
@endforeach

<div style="margin-top: 100px"></div>

<form method="POST" action="{{ route('createUser') }}">
    @csrf
    <div>
        <label>Name : </label>
        <input name="name" type="text"/>
    </div>
    <div>
        <label>Email : </label>
        <input name="email" type="email"/>
    </div>
    <div>
        <label>Password : </label>
        <input name="password" type="password"/>
    </div>
    <div>
        <button type="submit">Create User</button>
    </div>
</form>

{{-- end here --}}

<div class="container mt-3">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection
