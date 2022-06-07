@extends(panelLayout())

@section('content')
<div class="grid grid-cols-1 gap-6 mt-6 xl:grid-cols-1">

    <div class="card">
        <div class="card-header flex justify-between">
            <strong class="pt-2">{{ __('Manage posts') }}</strong>
            <a href='{{ route("module.blog.posts.create") }}' class="btn btn-sm btn-success">{{__('Create')}}</a>
        </div>

        <livewire:panel.posts-table />
        
    </div>

</div>
@endsection
