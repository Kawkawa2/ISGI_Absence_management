@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'ISGI')
<img src="{{asset('assets/images/logo.png')}}" class="logo" alt="Laravel Logo" @style('width:150px')>
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
