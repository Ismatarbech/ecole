<x-mail::message>
<div style="text-align: center; margin-bottom: 24px;">
    <div style="display: inline-block; background: #4154f1; color: #ffffff; padding: 10px 22px; border-radius: 8px; font-size: 22px; font-weight: 700; letter-spacing: 0.5px;">
        School
    </div>
</div>

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Bien cordialement,<br>
L'équipe School
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset

<div style="margin-top: 28px; padding-top: 16px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 12px; text-align: center;">
    Cet email a été envoyé automatiquement par la plateforme School.
</div>
</x-mail::message>
