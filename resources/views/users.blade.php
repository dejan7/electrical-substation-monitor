@extends('layouts.dashboard')

@section('pageName', "Korisnici")


@section('headerNavigation')
    <ul class="nav navbar-nav">
        <li>
            <a href="{{url('users/new')}}" class="btn btn-primary">
                Dodaj korisnika
            </a>
        </li>
    </ul>
@endsection

@section('page')
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                </div>
                <div class="content table-responsive table-full-width">
                    <table class="table table-striped">
                        <thead>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Email</th>
                        <th>Tip</th>
                        <th>Br. Telefona</th>
                        <th>Opcije</th>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role == 0 ? "Administrator" : "Operater"}}</td>
                                <td>{{$user->phone_number}}</td>
                                <td><a href="{{url('/users/' . $user->id)}}" class="btn btn-primary">Izmeni</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection