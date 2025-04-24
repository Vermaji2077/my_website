function fetchFlights() {
  const params = new URLSearchParams(window.location.search);
  $.get('backend/api.php', params.toString(), function(data) {
    let html = '';
    if (data.length) {
      html += '<table><thead><tr>' +
              '<th>Flight</th><th>From</th><th>To</th><th>Date</th><th>Price</th><th>Action</th>' +
              '</tr></thead><tbody>';
      data.forEach(f => {
        html += '<tr>' +
                `<td>${f.flight_number}</td>` +
                `<td>${f.departure}</td>` +
                `<td>${f.arrival}</td>` +
                `<td>${f.date}</td>` +
                `<td>$${f.price}</td>` +
                `<td><a href="booking.html?flight_id=${f.id}">Book</a></td>` +
                '</tr>';
      });
      html += '</tbody></table>';
    } else {
      html = '<p>No flights found.</p>';
    }
    $('#results').html(html);
  }, 'json');
}