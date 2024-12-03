import React, { useState, useEffect } from 'react';

const BookingList = () => {
  const [bookings, setBookings] = useState([]);

  useEffect(() => {
    fetch('http://localhost/api/read-bookings.php')
      .then(response => response.json())
      .then(data => setBookings(data))
      .catch(error => console.error('Error fetching bookings:', error));
  }, []);

  return (
    <div>
      <h2>Bookings</h2>
      <ul>
        {bookings.map(booking => (
          <li key={booking.id}>
            User ID: {booking.user_id}, Service ID: {booking.service_id}, Date: {booking.booking_date}, Status: {booking.status}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default BookingList;