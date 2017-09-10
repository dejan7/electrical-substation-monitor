@extends('layouts.dashboard')

@section('pageName', "Korisnici")


@section('page')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">{{$user->id ? 'Izmeni korisnika' : 'Dodaj korisnika'}}</h4>
                </div>
                <div class="content">
                    <form action="{{$user->id ? url('users/'. $user->id) : url('users/new')}}" method="POST">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ime</label>
                                    <input type="text" class="form-control border-input" name="name"  placeholder="" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email adresa</label>
                                    <input name="email" type="email" class="form-control border-input" placeholder="" value="{{$user->email}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tip korisnika</label>
                                    <select name="role" class="form-control border-input">
                                        <option value="0" {{$user->role && $user->role === 0 ? 'selected' : ''}}>Administrator</option>
                                        <option value="1" {{$user->role && $user->role === 1 ? 'selected' : ''}}>Operater</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Broj Telefona</label>
                                    <input type="text" class="form-control border-input" name="phone_number" placeholder="" value="{{$user->phone_number}}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Adresa</label>
                                    <input type="text" class="form-control border-input" name="address" value="{{$user->address}}">
                                </div>
                            </div>
                        </div>

                        @if (!$user->id || ($user->id && $user->id == auth()->user()->id))
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lozinka</label>
                                        <input type="password" name="password" class="form-control border-input" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ponovi lozinku</label>
                                        <input type="password" name="password_confirmation" class="form-control border-input" value="">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="text-center">
                            <button type="submit" class="btn btn-info btn-fill btn-wd">{{$user->id ? 'Ažuriraj korisnika' : 'Dodaj korisnika'}}</button>
                        </div>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection