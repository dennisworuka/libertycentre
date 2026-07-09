{{--
    Override of filament/filament v3.3.54's
    components/unsaved-action-changes-alert.blade.php — identical except
    @nonce on the <script> tag. This one is wrapped in Livewire's
    @script/@endscript (captured and re-injected by Livewire's own JS
    runtime, not rendered as a literal inline tag on first load), so
    unlike the other overrides in this vendor/ tree it's not fully
    confirmed to need or honour the nonce — added for consistency, verify
    in a real browser. See layout/base.blade.php for the full CSP nonce
    explanation. Re-diff on any filament/filament upgrade.
--}}
@if (filament()->hasUnsavedChangesAlerts())
    @script
        <script @nonce>
            window.addEventListener('beforeunload', (event) => {
                if (typeof @this === 'undefined') {
                    return
                }

                if (
                    [
                        ...(@js($this instanceof \Filament\Actions\Contracts\HasActions) ? ($wire.mountedActions ?? []) : []),
                        ...(@js($this instanceof \Filament\Forms\Contracts\HasForms)
                            ? ($wire.mountedFormComponentActions ?? [])
                            : []),
                        ...(@js($this instanceof \Filament\Infolists\Contracts\HasInfolists)
                            ? ($wire.mountedInfolistActions ?? [])
                            : []),
                        ...(@js($this instanceof \Filament\Tables\Contracts\HasTable)
                            ? [
                                  ...($wire.mountedTableActions ?? []),
                                  ...($wire.mountedTableBulkAction
                                      ? [$wire.mountedTableBulkAction]
                                      : []),
                              ]
                            : []),
                    ].length &&
                    !$wire?.__instance?.effects?.redirect
                ) {
                    event.preventDefault()
                    event.returnValue = true

                    return
                }
            })
        </script>
    @endscript
@endif
