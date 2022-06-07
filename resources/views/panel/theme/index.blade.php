@extends(panelLayout())

@section('content')
<div class="grid grid-cols-1 {{is_array($themes) && count($themes) > 1 ? 'md:grid-cols-2' : ''}} gap-4">
    @foreach($themes as $theme)
    <div class="card mb-4">
        <div class="card-header flex items-center justify-between">
            <strong class=''>
                {{ $theme['data']['name'] ?? '-' }}
                <small>(V-{{ $theme['data']['version'] ?? '-' }})</small>
            </strong>

            <button class="btn btn-sm btn-primary p-1 px-4" onclick='selectTheme("front", "{{ $theme["dir"] }}")'>{{ __('Select') }}</button>
        </div>
        <div class="card-body">
            <div class="flex justify-center">
                <img src="{{ $theme['screenshot'] ?? asset('img/upload-cover.png') }}" class='shadow mb-5' alt="Theme screenshot">
            </div>
            <strong>{{__('Description')}}: </strong> {{ $theme['data']['description'] ?? '-' }}
            <br>
            <strong>{{__('Author')}}: </strong> <a href="{{ $theme['data']['author_url'] ?? '#' }}" class='hover:text-blue-700'>{{ $theme['data']['author'] ?? '-' }}</a>
            <br>
            <strong>{{__('License')}}: </strong> {{ $theme['data']['license'] }}
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('scripts')
<script>
    let selectTheme = (type, dir) => {
        $.ajax({
            url: '{{ route("panel.theme.selectTheme") }}',
            method: 'POST',
            dataType: 'json',
            data: JSON.stringify({type: type, dir:dir}),
            success: (data) => {
                swal({icon: 'success', text: data.message});
            },
            error: (data) => {
                $(self).attr('disabled', false);
                swal(data.responseJSON.message);
            }
        })
    }
</script>
@endpush