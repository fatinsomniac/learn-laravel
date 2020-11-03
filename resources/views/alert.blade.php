@if (session()->has('success'))
<div class="container">
    <div class="row">
        <div class="col-md-6 py-2">
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        </div>
    </div>
</div>
@endif