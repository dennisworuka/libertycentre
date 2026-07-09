{{--
    Override of filament/support v3.3.54's assets.blade.php — identical
    except the inline `window.filamentData` script now carries @nonce
    (blocked otherwise under our strict script-src CSP). See the sibling
    override at resources/views/vendor/filament-panels/components/layout/base.blade.php
    for the full explanation. Re-diff on any filament/support upgrade.
--}}
@if (isset($data))
    <script @nonce>
        window.filamentData = @js($data)
    </script>
@endif

@foreach ($assets as $asset)
    @if (! $asset->isLoadedOnRequest())
        {{ $asset->getHtml() }}
    @endif
@endforeach

<style @nonce>
    :root {
        @foreach ($cssVariables ?? [] as $cssVariableName => $cssVariableValue) --{{ $cssVariableName }}:{{ $cssVariableValue }}; @endforeach
    }
</style>
