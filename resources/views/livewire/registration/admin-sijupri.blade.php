<div class="card">
    <div class="card-body">
        @if (Session::has('response') && Session::get('response')['title'] == 'Error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> NIP Telah terdaftar </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form wire:submit.prevent="store">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Role Admin</label>
                        <select wire:model="request.role_code"
                            class="form-control @error('request.role_code') is-invalid @enderror">
                            <option selected>Pilih Role Admin</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="admin_ukom">Admin Ukom</option>
                            <option value="admin_pak">Admin Pak</option>
                            <option value="admin_formasi">Admin Formasi</option>
                            <option value="admin_akp">Admin AKP</option>
                        </select>
                        @error('request.role_code')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3 has-validation">
                        <label class="form-label">Nama Lengkap</label>
                        <input wire:model="request.name" type="text"
                            class="form-control @error('request.name') is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('request.name')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input wire:model="request.nip" type="text"
                            class="form-control @error('request.nip') is-invalid @enderror" placeholder="NIP">
                        @error('request.nip')
                            <span class="invalid-feedback">
                                <strong>{{ str_replace('request.', '', $message) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="w-100">
                <button class="btn btn-sm btn-primary float-end" type="submit">
                    SIMPAN<i class="ms-1 uil-download-alt"></i>
                </button>
            </div>
        </form>
    </div>
</div>
