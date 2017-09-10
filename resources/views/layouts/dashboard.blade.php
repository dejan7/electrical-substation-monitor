@extends('layouts.app')
@section('content')
    <div class="wrapper">
        <div class="sidebar" data-background-color="black" data-active-color="danger">

            <!--
                Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
                Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
            -->

            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="{{url('/')}}" class="simple-text">
                        Trafo<i class="fa fa-bolt" style="color: #f4f3ef"></i>Monitor
                    </a>
                </div>

                <ul class="nav">
                    <li class="{{Route::current()->uri == "/" ? "active" : ''}}">
                        <a href="{{url('/')}}">
                            <i class="ti-pulse"></i>
                            <p>Monitor</p>
                        </a>
                    </li>
                    <li class="{{strpos(Route::current()->uri, "queries") === 0  ? "active" : ''}}">
                        <a href="{{url('/queries')}}">
                            <i class="ti-bar-chart"></i>
                            <p>Upiti</p>
                        </a>
                    </li>
                    <li class="{{strpos(Route::current()->uri, "users") === 0  ? "active" : ''}}">
                        <a href="{{url('/users')}}">
                            <i class="ti-user"></i>
                            <p>Korisnici</p>
                        </a>
                    </li>
                    <li class="{{strpos(Route::current()->uri, "alerts") === 0  ? "active" : ''}}">
                        <a href="{{url('/alerts')}}">
                            <i class="fa fa-exclamation-triangle"></i>
                            <p>Upozorenja</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar bar1"></span>
                            <span class="icon-bar bar2"></span>
                            <span class="icon-bar bar3"></span>
                        </button>
                        <a class="navbar-brand" href="#">@yield("pageName")</a>
                    </div>
                    @yield('headerNavigation')
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#">
                                    <i class="ti-user"></i>
                                    <p>{{auth()->user()->name}}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off"></i>
                                    <p>Odjavi se</p>
                                </a>
                                <form id="logout-form" action="{{ url('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>


            <div class="content">
                <div class="container-fluid">
                    @yield("page")
                </div>
            </div>


            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright">
                        &copy; <script>document.write(new Date().getFullYear())</script> Dejan Stošić 13466, Elektronski Fakultet Niš<br>
                        Završni rad iz predmeta Napredne baze podataka. Mentor: Aleksandar Stanimirović
                    </div>
                </div>
            </footer>

        </div>
    </div>
@endsection