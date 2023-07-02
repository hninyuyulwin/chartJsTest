<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Income Outcome</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/argon-design-system-free@1.2.0/assets/css/argon-design-system.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        @if (session()->has("success"))
            <div class="alert alert-success">{{ session("success") }}</div>
        @endif

        <div class="card card-body">
          <form action="" method="POST">
            @csrf
            <input type="text" class="btn btn-dark text-white" name="about" value="">
            <input type="number" class="btn btn-dark text-white" name="amount" value="">
            <input type="date" class="btn btn-dark text-white" name="date">
            <select name="type" class="btn btn-dark">
              <option value="in">၀င်ငွေ</option>
              <option value="out">ထွက်ငွေ</option>
            </select>
            <input type="submit" class="btn btn-success" value="စာရင်းသွင်းမည်">
          </form>
        </div>
      </div>
        <div class="col-6 mt-3">
            <ul class="list-group">
                @foreach ($data as $d)
                <li class="list-group-item d-flex justify-content-between mb-3">
                    <div class="">{{ $d->about }}<br>
                    <small class="text-muted">{{ $d->date }}</small>
                    </div>
                    @if ($d->type == "in")
                    <small class="text-success">+{{ $d->amount }} ကျပ်</small>
                    @else
                    <small class="text-danger">-{{ $d->amount }} ကျပ်</small>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-6 mt-3">
          <div class="card card-body">
            <div class="d-flex justify-content-between">
              <h5>ယနေ့ငွေ၀င်/ထွက်စာရင်း</h5>
              <div>
                <small class="text-success mr-2">၀င်ငွေ : +{{ $tdy_tot_income }}ks</small>
                <small class="text-danger">ထွက်ငွေ : -{{ $tdy_tot_outcome }}ks</small>
              </div>
            </div>
            <hr class="p-0 m-0">
            <div class="mt-3">
              <canvas id="inout"></canvas>
            </div>
          </div>
        </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const ctx = document.getElementById('inout');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: @json($day_arr),
        datasets: [
        {
          label: '၀င်ငွေ',
          data: @json($incomeAmount),
          borderWidth: 1,
          backgroundColor : "#2DCE89"
        },
        {
          label: 'ထွက်ငွေ',
          data: @json($outcomeAmount),
          borderWidth: 1,
          backgroundColor : "#F5365C"
        },
      ]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>
