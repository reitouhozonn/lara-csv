@extends('layouts.app')

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal-default-theme.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/remodal/1.1.1/remodal.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/ja.js" defer></script>
@endsection

@section('content')
<table class="table">
    <thead>
        <tr>
        <th scope="col">ID</th>
        <th scope="col">建築物条件</th>
        <th scope="col">建築物デザイン</th>
        <th scope="col">名前</th>
        <th scope="col">住所</th>
        <th scope="col">電話番号</th>
        <th scope="col">Fax</th>
        </tr>
    </thead>
    <tbody class="table-stripes-row-tbody">
    @foreach($contacts as $c)
        <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->condition_name }}</td>
        <td>{{ $c->design_name }}</td>
        <td>{{ $c->surname }}{{ $c->name }}</td>
        <td>{{ $c->zipcode }}<br>{{ $c->pref }}{{ $c->city }}{{ $c->street }}</td>
        <td>{{ $c->tel_number }}</td>
        <td>{{ $c->fax_number }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
