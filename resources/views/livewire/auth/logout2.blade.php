<a href="" class="btn btn-danger px-4" wire:click="_logout" wire:loading.attr="disabled" wire:target="_logout"
    wire:confirm="Anda akan keluar dari sistem?">
    <span wire:loading.remove wire.target="_logout"><i class="fa fa-power-off"></i> Keluar</span>
    <span wire:loading wire.target="_logout"> Please Wait...</span>
</a>
