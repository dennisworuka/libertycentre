{{--
    Override of filament/filament v3.3.54's
    components/page/unsaved-data-changes-alert.blade.php — identical
    except @nonce on each <script> tag. See the sibling
    unsaved-action-changes-alert.blade.php override for the @script/CSP
    caveat, and layout/base.blade.php for the full explanation. Re-diff
    on any filament/filament upgrade.
--}}
@php
    use Filament\Support\Facades\FilamentView;
@endphp

@if ($this->hasUnsavedDataChangesAlert())
    @if (FilamentView::hasSpaMode())
        @script
            <script @nonce>
                shouldPreventNavigation = () => {
                    if ($wire?.__instance?.effects?.redirect) {
                        return
                    }

                    return (
                        window.jsMd5(
                            JSON.stringify($wire.data).replace(/\\/g, ''),
                        ) !== $wire.savedDataHash
                    )
                }

                const showUnsavedChangesAlert = () => {
                    return confirm(@js(__('filament-panels::unsaved-changes-alert.body')))
                }

                document.addEventListener('livewire:navigate', (event) => {
                    if (typeof @this !== 'undefined') {
                        if (!shouldPreventNavigation()) {
                            return
                        }

                        if (showUnsavedChangesAlert()) {
                            return
                        }

                        event.preventDefault()
                    }
                })

                window.addEventListener('beforeunload', (event) => {
                    if (!shouldPreventNavigation()) {
                        return
                    }

                    event.preventDefault()
                    event.returnValue = true
                })
            </script>
        @endscript
    @else
        @script
            <script @nonce>
                window.addEventListener('beforeunload', (event) => {
                    if (
                        window.jsMd5(
                            JSON.stringify($wire.data).replace(/\\/g, ''),
                        ) === $wire.savedDataHash ||
                        $wire?.__instance?.effects?.redirect
                    ) {
                        return
                    }

                    event.preventDefault()
                    event.returnValue = true
                })
            </script>
        @endscript
    @endif
@endif
