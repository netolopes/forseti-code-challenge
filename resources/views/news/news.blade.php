@extends('layout.layout')

@section('content')
    <div class="row" style="margin-top: 5rem;">
        <div class="row align-center">
            <div class="col ml-10">
                <h2>Notícias portal Comprasnet</h2>
            </div>
            @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
            @endif
            @if (\Session::has('error'))
            <div class="alert alert-danger">
                <ul>
                    <li>{!! \Session::get('error') !!}</li>
                </ul>
            </div>
        @endif
            <div class="col-lg-10 text-center">
                <a class="btn btn-primary" href={{ url("/news?page=0"); }}>1</a>
                <a class="btn btn-primary" href={{ url("/news?page=30"); }}>2</a>
                <a class="btn btn-primary" href={{ url("/news?page=60"); }}>3</a>
                <a class="btn btn-primary" href={{ url("/news?page=90"); }}>4</a>
                <a class="btn btn-primary" href={{ url("/news?page=120"); }}>5</a>
            </div>
            <div class="col-lg-2 text-center">
                <a class="btn btn-primary" href={{ url("/save"); }}>Salvar Dados</a>
            </div>
          </div>
    </div>

    <table class="table table-striped">
        <tr>
            <th>Noticias</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Detalhes</th>
        </tr>

        @foreach ($titulos as $key => $value)
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $arrDts[$key] }}</td>
            <td>{{ $arrHrs[$key] }}</td>
            <td>
                <a class="btn btn-info" href={{ url("/details?link=".$links[$key]); }}>Detalhes</a>
            </td>
        </tr>
        @endforeach
    </table>

@endsection

