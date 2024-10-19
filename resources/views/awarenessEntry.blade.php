<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Dashboard | Awareness Tracker</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .star-rating {
            direction: rtl;
            display: inline-flex;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 2rem;
            color: lightgray;
            cursor: pointer;
        }

        .star-rating input[type="radio"]:checked ~ label {
            color: gold;
        }

        .star-rating input[type="radio"]:hover ~ label {
            color: gold;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: gold;
        }


    </style>
</head>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Awareness Tracker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@if (session('awareness_reminder'))
    <div class="alert alert-warning text-center">
        Don't forget to enter today's awareness !!!
    </div>
@endif

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card mb-4 shadow-sm border-0 rounded">
                <h6 class="card-header text-center ">Score in Last 7 Days</h6>
                <div class="card-body text-center">
                    <h6>{{ $weeklyMood }}</h6> <!-- Display the mood of last 7 days -->
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card mb-4 shadow-sm border-0 rounded">
                <h6 class="card-header text-center ">Score in Last {{ now()->format('l') }}</h6>
                <div class="card-body text-center">
                    <h5>{{ $lastWeekDayMood }}</h5> <!-- Display the mood of last week day -->
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Main Content -->
<main class="entry-form">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card mb-4 shadow-sm border-0 rounded">
                    <h5 class="card-header text-center bg-secondary text-white">Create New Awareness</h5>
                    <div class="card-body">
                        <!-- Display Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form to create new entry -->
                        <form id="awarenessForm" action="{{ route('awarenessEntry.store') }}" method="POST">
                            @csrf

                            <!-- Creative Hours Input -->
                            <div class="form-group mb-3">
                                <label for="creative_hours">Hours of Creative Work</label>
                                <input type="number" name="creative_hours" id="creative_hours" class="form-control"
                                       value="{{ old('creative_hours') }}" min="0" step="0.1" required>
                            </div>

                            <!-- Quality Score Input -->
                            <div class="form-group mb-3">
                                <label>Quality Score:</label><br>
                                <div class="star-rating">
                                    <input type="radio" id="star5" name="score" value="2" class="btn-check"
                                           autocomplete="off"/>
                                    <label for="star5" title="Excellent">★</label>

                                    <input type="radio" id="star4" name="score" value="1" class="btn-check"
                                           autocomplete="off"/>
                                    <label for="star4" title="Good">★</label>

                                    <input type="radio" id="star3" name="score" value="0" class="btn-check"
                                           autocomplete="off"/>
                                    <label for="star3" title="Average">★</label>

                                    <input type="radio" id="star2" name="score" value="-1" class="btn-check"
                                           autocomplete="off"/>
                                    <label for="star2" title="Fair">★</label>

                                    <input type="radio" id="star1" name="score" value="-2" class="btn-check"
                                           autocomplete="off"/>
                                    <label for="star1" title="Poor">★</label>
                                </div>
                                <span id="selectedScore" class="ml-2"></span>
                            </div>

                            <!-- Note Input -->
                            <div class="form-group mb-3">
                                <label for="note">Note for the Day</label>
                                <textarea name="note" id="note" class="form-control"
                                          rows="4">{{ old('note') }}</textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-block">Save Entry</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card mb-4 shadow-sm border-0 rounded">
                    <h5 class="card-header text-center bg-secondary text-white">History</h5>
                    <div class="card-body" style="overflow-x: scroll">
                        <!-- Table for displaying history -->
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Creative Hours</th>
                                <th>Quality Score</th>
                                <th>Note</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($entries->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No entries found.</td>
                                </tr>
                            @else
                                @foreach ($entries as $entry)
                                    <tr>
                                        <td>{{ $entry->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $entry->created_at->format('l') }}</td>
                                        <td>{{ $entry->creative_hours }}</td>
                                        <td>
                                            @php
                                                $qualityLabels = [
                                                    2 => 'Excellent',
                                                    1 => 'Good',
                                                    0 => 'Average',
                                                    -1 => 'Fair',
                                                    -2 => 'Poor'
                                                ];
                                            @endphp
                                            {{ $qualityLabels[$entry-> qualityScore-> score] ?? 'Unknown' }}
                                        </td>
                                        <td>{{ $entry->note }}</td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-around">
                                                <button class="btn btn-light btn-sm"
                                                        onclick="editEntry({{ $entry->id }}, {{ $entry->creative_hours }}, {{ $entry->qualityScore->score }}, '{{ addslashes($entry->note) }}')">
                                                    <i class="bi bi-pencil text-success"></i>
                                                </button>

                                                <form action="{{ route('awarenessEntry.destroy', $entry->id) }}"
                                                      method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-light btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this data?');">
                                                        <i class="bi bi-trash text-danger"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (session('success'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast align-items-center bg-success text-white border-0 show" role="alert"
                 aria-live="assertive"
                 aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>

<script>
    function editEntry(id, creativeHours, qualityScore, note) {
        const form = document.getElementById('awarenessForm');

        if (form) {
            document.getElementById('creative_hours').value = creativeHours;
            document.querySelector(`input[name="score"][value="${qualityScore}"]`).checked = true;
            document.getElementById('note').value = note;

            form.action = `/awarenessEntry/${id}`;

            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'PUT';
                form.appendChild(methodInput);
            }

            const header = document.querySelector('h5.card-header');
            if (header) {
                header.innerText = 'Update Awareness';
            }

            const submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.innerText = 'Update Entry';
            }
        } else {
            console.error('Form not found.');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
    });

    //for star rating
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('input[name="score"]');
        const scoreDisplay = document.getElementById('selectedScore');
        const scoreLabels = {
            '2': 'Excellent',
            '1': 'Good',
            '0': 'Average',
            '-1': 'Fair',
            '-2': 'Poor'
        };

        stars.forEach(star => {
            star.addEventListener('change', function () {
                scoreDisplay.textContent = `${scoreLabels[this.value]}`;
            });
        });

        //toast
        const toastEl = document.getElementById('successToast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
