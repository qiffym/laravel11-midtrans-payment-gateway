<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <title>Laravel Midtrans</title>
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('donations.index') }}">❤️Donations</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                    href="{{ route('donations.create') }}">Make a
                                    donation</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="bg-body-tertiary text-secondary px-4 py-5 text-center">
            <div class="py-5">
                <h1 class="display-5 fw-bold text-white">🇵🇸 Donasi untuk Palestina 🇵🇸</h1>
                <div class="col-lg-6 mx-auto">
                    <p class="fs-5 mb-4 text-muted">Platform donasi untuk saudara kita di Palestina.</p>
                </div>
            </div>
        </div>

        <div class="container px-4 py-5">
            <form id="donation_form" class="row g-3" method="post" action="{{ route('donations.store') }}">
                @method('post')
                @csrf

                <legend>Donation</legend>
                <div class="col-md-6">
                    <label for="donor_name" class="form-label">Nama</label>
                    <input type="text" name="donor_name" class="form-control" id="donor_name">
                </div>
                <div class="col-md-6">
                    <label for="donor_email" class="form-label">Email</label>
                    <input type="email" name="donor_email" class="form-control" id="donor_email">
                </div>
                <div class="col-md-12">
                    <label for="donation_type" class="form-label">Jenis Donasi</label>
                    <select name="donation_type" id="donation_type" class="form-select">
                        <option selected>Pilih jenis donasi</option>
                        <option value="medis_kesehatan">Medis & Kesehatan</option>
                        <option value="kemanusiaan">Kemanusiaan</option>
                        <option value="bencana_alam">Bencana Alam</option>
                        <option value="rumah_ibadah">Rumah Ibadah</option>
                        <option value="beasiswa_pendidikan">Beasiswa & Pendidikan</option>
                        <option value="sarana_infrastruktur">Sarana & Infrastruktur</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="amount" class="form-label">Jumlah</label>
                    <input type="number" name="amount" class="form-control" id="amount">
                </div>
                <div class="col-md-6">
                    <label for="note" class="form-label">Catatan (optional)</label>
                    <textarea name="note" class="form-control" id="note" rows="3"></textarea>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary px-5">Kirim</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="border-top">
        <div class="container px-4 py-5">
            <p>Donations &copy; 2024. Made with ❤️ by Qiff Ya Muhammad</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <script>
        $("#donation_form").submit(function(e) {
            e.preventDefault();

            $.post("/api/donation", {
                _method: 'POST',
                _token: '{{ csrf_token() }}',
                donor_name: $('input#donor_name').val(),
                donor_email: $('input#donor_email').val(),
                donation_type: $('select#donation_type').val(),
                amount: $('input#amount').val(),
                note: $('textarea#note').val(),
            }, function(data, status) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        alert("payment success!");
                        console.log(result);
                    },
                    onPending: function(result) {
                        alert("wating your payment!");
                        console.log(result);
                    },
                    onError: function(result) {
                        alert("payment failed!");
                        console.log(result);
                    },
                });
                return false;
            })
        })
    </script>
</body>

</html>
