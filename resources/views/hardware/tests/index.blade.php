@extends('layouts/default')

@section('content')
<div class="container">
    <h1>Tests — {{ $asset->name }} (ID: {{ $asset->id }})</h1>

    @if($failed->count() > 0)
        <div class="alert alert-danger" role="alert" style="margin:12px 0;">
            <strong>Mislukte tests (laatste run per component):</strong>
            {{ $failed->implode(', ') }}
        </div>
    @endif

    <form action="{{ route('asset-tests.store', $asset->id) }}" method="POST" style="margin:16px 0;">
        @csrf
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end;">
            <div>
                <label>Component</label>
                <input type="text" name="component" required class="form-control" placeholder="keyboard / hdmi / wifi">
            </div>
            <div>
                <label>Resultaat</label>
                <select name="result" required class="form-control">
                    <option value="pass">✔ Pass</option>
                    <option value="fail">✖ Fail</option>
                    <option value="n_a">N.v.t.</option>
                </select>
            </div>
            <div>
                <label>Opmerking</label>
                <input type="text" name="comment" class="form-control" placeholder="optioneel">
            </div>
            <div>
                <label>Datum/Tijd</label>
                <input type="datetime-local" name="tested_at" class="form-control">
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Toevoegen</button>
            </div>
        </div>
    </form>

    <h3>Geschiedenis</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Datum</th>
                <th>Component</th>
                <th>Resultaat</th>
                <th>Operator</th>
                <th>Opmerking</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tests as $t)
            <tr>
                <td>{{ \Carbon\Carbon::parse($t->tested_at)->format('Y-m-d H:i') }}</td>
                <td>{{ $t->component }}</td>
                <td>{{ strtoupper($t->result) }}</td>
                <td>{{ optional($t->user)->name ?? '—' }}</td>
                <td>{{ $t->comment ?? '—' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
