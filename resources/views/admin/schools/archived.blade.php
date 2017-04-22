
@extends ('layouts.admin')

@section( 'section-header' )

    <h1 class="title">
        Schools
    </h1>

@endsection

@section( 'section-menu' )

    @include( 'admin.schools.partials.menu' )

@endsection

@section('section-content')

    @if( $schools->count() > 0 )

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach( $schools as $school )
                <tr>
                    <td>{{ $school->name }}</td>
                    <td>{!! $school->full_address !!}</td>
                    <td>
                        <nav class="level">
                            <div class="level-left"></div>
                            <div class="level-right">
                                <p class="level-item">
                                    <a href="{{ route( 'admin.schools.edit', [ $school->id ] ) }}">
                                        <span class="icon"><i class="fa fa-pencil-square-o"></i></span>
                                    </a>
                                </p>
                                <p class="level-item">
                                    <a href="{{ route( 'admin.schools.destroy', [ $school->id ] ) }}">
                                        <span class="icon"><i class="fa fa-trash"></i></span>
                                    </a>
                                </p>
                            </div>
                        </nav>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

    @else

        <p>There are no schools, but you can <a href="{{ route( 'admin.schools.create') }}">add one</a> now.</p>

    @endif

@endsection