<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BankLoan Pro Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .navbar {
            background-color: #001f3f;
        }
        .nav-link {
            color: white !important;
        }
        .nav-link i {
            margin-right: 5px;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status-in-behandeling {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-goedgekeurd {
            background-color: #d4edda;
            color: #155724;
        }
        .status-afgekeurd {
            background-color: #f8d7da;
            color: #721c24;
        }
        .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-body .display-4 {
            margin: 0;
        }
        .card-body i {
            font-size: 2rem;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table .rounded-circle {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .filter-group {
            display: flex;
            align-items: center;
        }
        .filter-group select {
            margin-left: 5px;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">BankLoan Pro</a>
            <div class="collapse navbar-collapse justify-content-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-plus"></i>Nieuwe Lening</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-users"></i>Klanten</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-calculator"></i>Calculator</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <i class="fas fa-user-circle text-white fs-2"></i>
            </div>
        </div>
    </nav>
    <div class="container my-4">
        <h1 class="mb-3 text-center">Dashboard</h1>
        <p class="text-muted text-center">Overzicht van alle leningen bij de bank</p>
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="display-4 text-primary">124</div>
                        <div class="ms-3">
                            <p class="mb-0 text-muted">Totaal Aantal Leningen</p>
                            <i class="fas fa-chart-bar text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="display-4 text-success">78</div>
                        <div class="ms-3">
                            <p class="mb-0 text-muted">Goedgekeurde Leningen</p>
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="display-4 text-danger">21</div>
                        <div class="ms-3">
                            <p class="mb-0 text-muted">Afgekeurde Leningen</p>
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="display-4 text-warning">25</div>
                        <div class="ms-3">
                            <p class="mb-0 text-muted">In Behandeling</p>
                            <i class="fas fa-hourglass-half text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row align-items-center mb-4">
            <input type="text" class="form-control mb-2 mb-md-0 me-md-2" placeholder="Zoek op klantnaam of e-mail...">
            <div class="d-flex flex-column flex-md-row align-items-center mb-2 mb-md-0 me-md-2">
                <div class="filter-group">
                    <i class="fas fa-filter"></i>
                    <select class="form-select me-md-2 mb-2 mb-md-0">
                        <option>Status</option>
                    </select>
                </div>
                <div class="filter-group">
                    <i class="fas fa-sort"></i>
                    <select class="form-select me-md-2 mb-2 mb-md-0">
                        <option>Sorteren</option>
                    </select>
                </div>
                <div class="filter-group">
                    <i class="fas fa-calendar-alt"></i>
                    <select class="form-select">
                        <option>Datum</option>
                    </select>
                </div>
            </div>
            <button class="btn btn-primary">+ Nieuwe Lening</button>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Klant</th>
                            <th>Bedrag</th>
                            <th>Looptijd</th>
                            <th>Status</th>
                            <th>Datum Aanvraag</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="d-flex align-items-center">
                                <div class="bg-secondary rounded-circle text-white text-center">JJ</div>
                                <div class="ms-2">
                                    <p class="mb-0 fw-bold">Jan Jansen</p>
                                    <p class="mb-0 text-muted">jan@example.com</p>
                                </div>
                            </td>
                            <td>€25.000</td>
                            <td>5 jaar</td>
                            <td><span class="status-badge status-in-behandeling">In behandeling</span></td>
                            <td>15 Mar 2025</td>
                            <td>
                                <button class="btn btn-link text-primary p-0"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex align-items-center">
                                <div class="bg-secondary rounded-circle text-white text-center">PV</div>
                                <div class="ms-2">
                                    <p class="mb-0 fw-bold">Petra de Vries</p>
                                    <p class="mb-0 text-muted">petra@example.com</p>
                                </div>
                            </td>
                            <td>€10.000</td>
                            <td>3 jaar</td>
                            <td><span class="status-badge status-goedgekeurd">Goedgekeurd</span></td>
                            <td>10 Mar 2025</td>
                            <td>
                                <button class="btn btn-link text-primary p-0"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="d-flex align-items-center">
                                <div class="bg-secondary rounded-circle text-white text-center">MB</div>
                                <div class="ms-2">
                                    <p class="mb-0 fw-bold">Mark Bakker</p>
                                    <p class="mb-0 text-muted">mark@example.com</p>
                                </div>
                            </td>
                            <td>€50.000</td>
                            <td>10 jaar</td>
                            <td><span class="status-badge status-afgekeurd">Afgekeurd</span></td>
                            <td>05 Mar 2025</td>
                            <td>
                                <button class="btn btn-link text-primary p-0"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-link text-danger p-0"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-outline-secondary mx-1">1</button>
            <button class="btn btn-outline-secondary mx-1">2</button>
            <button class="btn btn-outline-secondary mx-1">3</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>