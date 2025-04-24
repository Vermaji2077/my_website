<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "airline");
if ($mysqli->connect_error) die(json_encode(["error" => "DB connection failed"]));
$action = $_POST['action'] ?? '';

if ($action == 'search_flights') {
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];

    $stmt = $mysqli->prepare("
        SELECT f.*, a.name AS airline 
        FROM flights f 
        JOIN airlines a ON f.airline_id = a.airline_id 
        WHERE f.origin = ? AND f.destination = ? AND DATE(f.departure_time) = ?
    ");
    $stmt->bind_param("sss", $origin, $destination, $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $flights = [];
    while ($row = $result->fetch_assoc()) $flights[] = $row;
    echo json_encode($flights);

} elseif ($action == 'get_seats') {
    $flight_id = $_POST['flight_id'];
    $stmt = $mysqli->prepare("SELECT seat_number, is_booked FROM seats WHERE flight_id = ?");
    $stmt->bind_param("i", $flight_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $seats = [];
    while ($row = $result->fetch_assoc()) $seats[] = $row;
    echo json_encode($seats);

} elseif ($action == 'book_seat') {
    $flight_id = $_POST['flight_id'];
    $seat_number = $_POST['seat'];
    $name = $_POST['name'];
    $user_id = 1; // assuming a logged-in user, replace with actual logic if needed

    // Check if the seat is already booked
    $stmt = $mysqli->prepare("SELECT is_booked FROM seats WHERE flight_id = ? AND seat_number = ?");
    $stmt->bind_param("is", $flight_id, $seat_number);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result || $result['is_booked']) {
        echo json_encode(["success" => false, "message" => "Seat already booked"]);
        exit;
    }

    // Mark seat as booked
    $stmt = $mysqli->prepare("UPDATE seats SET is_booked = TRUE WHERE flight_id = ? AND seat_number = ?");
    $stmt->bind_param("is", $flight_id, $seat_number);
    $stmt->execute();

    // Get seat_id
    $stmt = $mysqli->prepare("SELECT seat_id FROM seats WHERE flight_id = ? AND seat_number = ?");
    $stmt->bind_param("is", $flight_id, $seat_number);
    $stmt->execute();
    $seat_row = $stmt->get_result()->fetch_assoc();
    $seat_id = $seat_row['seat_id'];

    // Insert into reservations
    $stmt = $mysqli->prepare("INSERT INTO reservations (user_id, flight_id, seat_id) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $user_id, $flight_id, $seat_id);
    $stmt->execute();
    $reservation_id = $stmt->insert_id;

    echo json_encode(["success" => true, "booking_id" => $reservation_id]);

} elseif ($action == 'get_booking') {
    $booking_id = $_POST['booking_id'];
    $stmt = $mysqli->prepare("
        SELECT r.*, f.flight_number, f.origin, f.destination, f.departure_time, a.name AS airline, s.seat_number 
        FROM reservations r 
        JOIN flights f ON r.flight_id = f.flight_id 
        JOIN airlines a ON f.airline_id = a.airline_id
        JOIN seats s ON r.seat_id = s.seat_id
        WHERE r.reservation_id = ?
    ");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    echo json_encode($result);

} else {
    echo json_encode(["error" => "Invalid action"]);
}
?>
