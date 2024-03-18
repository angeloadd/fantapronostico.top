<div class="modal fade" id="logOutModal" tabindex="-1" aria-labelledby="logOutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="logOutModalLabel">Logout</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            Sei sicuro di voler fare logout?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info text-dark" data-bs-dismiss="modal">Chiudi</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn text-base-100 btn-primary">
                    Logout
                </button>
            </form>
        </div>
        </div>
    </div>
</div>
