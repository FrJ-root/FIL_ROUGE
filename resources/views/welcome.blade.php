@extends('layouts.app')

@section('content')
    @include('components.hero')
    @include('components.propositions')
    @include('components.destinations')
    @include('components.cta')
@endsection

@push('scripts')
<script>
    // Any additional page-specific scripts can go here
</script>
@endpush