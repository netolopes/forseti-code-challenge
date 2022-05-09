@extends('layout.layout')

@section('content')
    <div class="row" style="margin-top: 5rem;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a class="btn btn-info" href={{ url("/news"); }}>Voltar</a>
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>Detalhes</th>
        </tr>
        @foreach ($data as $key => $value)
        <tr>
            <td>{{ $value }}</td>
        </tr>
        @endforeach
    </table>
@endsection
