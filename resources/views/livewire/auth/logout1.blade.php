<li class="nav-item">
    <a href="#" class="nav-link" wire:click="_logout" wire:loading.attr="disabled" wire:target="_logout"
        wire:confirm="Anda akan keluar dari sistem?">
        <i class="nav-icon fas fa-power-off"></i>
        <p>
            <span wire:loading.remove wire.target="_logout"> Logout</span>
            <span wire:loading wire.target="_logout"> Please Wait...</span>
        </p>
    </a>
</li>
