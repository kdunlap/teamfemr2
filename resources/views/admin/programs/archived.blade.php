
@extends ('layouts.admin')

@section( 'section-header' )

    <div class="header">
        <h1 class="title">Outreach Programs</h1>
    </div>

    <div class="level breadcrumbs is-mobile">
        <div class="level-left">

            <a class="level-item"href="{{ route( 'admin.dashboard.index' ) }}">Dashboard</a>
            <span class="level-item separator">&gt</span>
            <a class="level-item" href="{{ route( 'admin.programs.index' ) }}">Outreach Programs</a>
            <span class="level-item separator">&gt</span>
            <span class="level-item">Archived</span>

        </div>
    </div>

@endsection

@section( 'section-menu' )

    @include( 'admin.programs.partials.tabs' )

@endsection

@section('section-content')

    @if( $programs->count() > 0 )

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Year Initiated</th>
                    <th>Participants</th>
                    <th>Matriculants per class</th>
                    <th>Uses EMR</th>
                </tr>
            </thead>

            <tbody>
                @foreach( $programs as $program )
                <tr>
                    <td>
                        {!! Form::open([ 'method' => 'post', 'route' => [ 'admin.programs.restore', $program->id ] ]) !!}
                        <button type="submit" class="button is-small" title="restore">
                            <span class="icon is-small"><i class="fa fa-undo"></i></span>
                        </button>
                        {!! Form::close() !!}
                    </td>
                    <td>{{ $program->name }}</td>
                    <td>{{ $program->year_initiated }}</td>
                    <td>{{ $program->yearly_outreach_participants }}</td>
                    <td>{{ $program->matriculants_per_class }}</td>
                    <td>{{ ( $program->uses_emr ) ? 'Yes' : 'No' }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

    @else

        <p>There are no archived programs</p>

    @endif

@endsection