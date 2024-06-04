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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Donor Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Donation Type</th>
                        <th scope="col">Status</th>
                        <th scope="col" style="text-align: center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donations as $donation)
                        <tr>
                            <th scope="row"><code>{{ $donation->id }}</code></th>
                            <td>{{ $donation->donor_name }}</td>
                            <td>{{ Number::currency($donation->amount, 'IDR', 'id') }}</td>
                            <td>{{ Str::title(str_replace('_', ' ', $donation->donation_type)) }}</td>
                            <td>{{ Str::ucfirst($donation->status->value) }}</td>
                            <td style="text-align: center">
                                @if ($donation->status == \App\Enums\DonationStatusEnum::PENDING)
                                    <button class="btn btn-success btn-sm"
                                        onclick="snap.pay('{{ $donation->snap_token }}')">
                                        Complete Payment
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    {{ $donations->links() }}
                </tfoot>
            </table>
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
</body>

</html>
