<?= $this->extend('layouts/default'); ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header text-bg-primary ">
                <div class="card-title">
                    Daftar Produk
                </div>
            </div>
            <div class="card-body">
                <a class="btn btn-primary" href="/fetch">Fetch</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>