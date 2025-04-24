<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Flights</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Add New Flight</h2>
  <form method="post" action="backend/api.php">
    <input type="hidden" name="action" value="add_flight">
    <div class="mb-3">
      <input type="text" class="form-control" name="flight_number" placeholder="Flight Number" required>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="airline" placeholder="Airline" required>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="origin" placeholder="Origin" required>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="destination" placeholder="Destination" required>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="duration" placeholder="Duration (e.g. 2h 30m)" required>
    </div>
    <div class="mb-3">
      <input type="datetime-local" class="form-control" name="departure_time" required>
    </div>
    <div class="mb-3">
      <input type="number" class="form-control" name="seats_available" placeholder="Total Seats" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Flight</button>
  </form>
</div>
</body>
</html>