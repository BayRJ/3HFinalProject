import React, { useContext, useState } from 'react'
import { Line } from 'react-chartjs-2'
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
} from 'chart.js'
import { services } from '../../context/GlobalState'

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
)

const AdminDashboard = () => {
  // Example data for bookings, services, and payments
  const [activeTab, setActiveTab] = useState('bookings') // Track active tab
  const [bookingStatus, setBookingStatus] = useState('all') // Track booking filter
  const [serviceName, setServiceName] = useState('')
  const [serviceList, setServiceList] = useState(services)
  const [paymentFilter, setPaymentFilter] = useState('all')
  const [therapistSchedule, setTherapistSchedule] = useState([])
  const [newAvailability, setNewAvailability] = useState('')
  const [newService, setNewService] = useState({
    name: '',
    price: '',
    duration: '',
    description: '',
  })

  const bookings = [
    {
      id: 1,
      customer: 'John Doe',
      service: 'Massage',
      status: 'confirmed',
      date: '2024-11-20',
      time: '10:00 AM',
    },
    {
      id: 2,
      customer: 'Jane Smith',
      service: 'Facial',
      status: 'pending',
      date: '2024-11-22',
      time: '2:00 PM',
    },
  ]

  const payments = [
    { id: 1, amount: 80, status: 'paid', date: '2024-11-20' },
    { id: 2, amount: 100, status: 'unpaid', date: '2024-11-22' },
  ]

  // Chart data for reports
  const chartData = {
    labels: ['January', 'February', 'March', 'April', 'May'],
    datasets: [
      {
        label: 'Bookings',
        data: [30, 45, 35, 50, 60],
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.1,
      },
      {
        label: 'Earnings',
        data: [2000, 3000, 2500, 4000, 5000],
        fill: false,
        borderColor: 'rgb(255, 99, 132)',
        tension: 0.1,
      },
    ],
  }

  // Handlers for different actions
  const handleAddService = (e) => {
    e.preventDefault()
    setServiceList([
      ...serviceList,
      { ...newService, id: serviceList.length + 1 },
    ])
    setNewService({ name: '', price: '', duration: '', description: '' })
  }

  const handleAddAvailability = () => {
    setTherapistSchedule([...therapistSchedule, newAvailability])
    setNewAvailability('')
  }

  const handleBookingAction = (action, bookingId) => {
    // Perform action like approve, cancel, reschedule (mocked for now)
    alert(`${action} booking with ID: ${bookingId}`)
  }

  return (
    <div className="w-full h-[120vh] bg-orange-100 -mt-4 pt-1">
      <div className="max-w-6xl mx-auto p-6 bg-gray-100 mt-28 rounded-2xl">
        <h1 className="text-3xl font-semibold mb-6">Admin Dashboard</h1>

        {/* Tabs */}
        <div className="flex space-x-6 mb-8">
          <button
            onClick={() => setActiveTab('bookings')}
            className="text-lg font-medium text-blue-600"
          >
            Manage Bookings
          </button>
          <button
            onClick={() => setActiveTab('services')}
            className="text-lg font-medium text-blue-600"
          >
            Manage Services
          </button>
          <button
            onClick={() => setActiveTab('schedule')}
            className="text-lg font-medium text-blue-600"
          >
            Therapist Schedule
          </button>
          <button
            onClick={() => setActiveTab('payments')}
            className="text-lg font-medium text-blue-600"
          >
            Payments & Reports
          </button>
        </div>

        {/* Booking Management */}
        {activeTab === 'bookings' && (
          <div>
            <h2 className="text-2xl font-semibold mb-4">Manage Bookings</h2>

            {/* Filters */}
            <div className="mb-4">
              <label className="mr-2">Booking Status:</label>
              <select
                value={bookingStatus}
                onChange={(e) => setBookingStatus(e.target.value)}
                className="p-2 border rounded"
              >
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
              </select>
            </div>

            {/* Booking Table */}
            <table className="table-auto w-full border-collapse">
              <thead>
                <tr className="border-b">
                  <th className="p-2">ID</th>
                  <th className="p-2">Customer</th>
                  <th className="p-2">Service</th>
                  <th className="p-2">Date & Time</th>
                  <th className="p-2">Status</th>
                  <th className="p-2">Actions</th>
                </tr>
              </thead>
              <tbody>
                {bookings
                  .filter(
                    (booking) =>
                      bookingStatus === 'all' ||
                      booking.status === bookingStatus
                  )
                  .map((booking) => (
                    <tr key={booking.id}>
                      <td className="p-2">{booking.id}</td>
                      <td className="p-2">{booking.customer}</td>
                      <td className="p-2">{booking.service}</td>
                      <td className="p-2">
                        {booking.date} at {booking.time}
                      </td>
                      <td className="p-2">{booking.status}</td>
                      <td className="p-2">
                        <button
                          onClick={() =>
                            handleBookingAction('Approve', booking.id)
                          }
                          className="bg-green-500 text-white px-4 py-1 rounded mr-2"
                        >
                          Approve
                        </button>
                        <button
                          onClick={() =>
                            handleBookingAction('Cancel', booking.id)
                          }
                          className="bg-red-500 text-white px-4 py-1 rounded mr-2"
                        >
                          Cancel
                        </button>
                        <button
                          onClick={() =>
                            handleBookingAction('Reschedule', booking.id)
                          }
                          className="bg-yellow-500 text-white px-4 py-1 rounded"
                        >
                          Reschedule
                        </button>
                      </td>
                    </tr>
                  ))}
              </tbody>
            </table>
          </div>
        )}

        {/* Manage Services */}
        {activeTab === 'services' && (
          <div>
            <h2 className="text-2xl font-semibold mb-4">Manage Services</h2>

            {/* Add Service Form */}
            <form onSubmit={handleAddService} className="mb-6 space-y-4">
              <input
                type="text"
                className="w-full p-2 border rounded"
                placeholder="Service Name"
                value={newService.name}
                onChange={(e) =>
                  setNewService({ ...newService, name: e.target.value })
                }
                required
              />
              <input
                type="number"
                className="w-full p-2 border rounded"
                placeholder="Price"
                value={newService.price}
                onChange={(e) =>
                  setNewService({ ...newService, price: e.target.value })
                }
                required
              />
              <input
                type="text"
                className="w-full p-2 border rounded"
                placeholder="Duration"
                value={newService.duration}
                onChange={(e) =>
                  setNewService({ ...newService, duration: e.target.value })
                }
                required
              />
              <textarea
                className="w-full p-2 border rounded"
                placeholder="Description"
                value={newService.description}
                onChange={(e) =>
                  setNewService({ ...newService, description: e.target.value })
                }
                required
              />
              <button
                type="submit"
                className="bg-blue-600 text-white px-6 py-2 rounded"
              >
                Add Service
              </button>
            </form>

            {/* Service List */}
            <div className="space-y-4">
              {serviceList.map((service) => (
                <div
                  key={service.id}
                  className="bg-white p-4 rounded shadow-md flex justify-between"
                >
                  <div>
                    <h3 className="font-semibold">{service.name}</h3>
                    <p>{service.description}</p>
                    <p className="text-gray-500">
                      Price: ${service.price} | Duration: {service.duration}
                    </p>
                  </div>
                  <div>
                    <button className="bg-yellow-500 text-white px-4 py-1 rounded mr-2">
                      Edit
                    </button>
                    <button className="bg-red-500 text-white px-4 py-1 rounded">
                      Delete
                    </button>
                  </div>
                </div>
              ))}
            </div>
          </div>
        )}

        {/* Therapist Schedule */}
        {activeTab === 'schedule' && (
          <div>
            <h2 className="text-2xl font-semibold mb-4">Therapist Schedule</h2>
            <input
              type="text"
              placeholder="Add new availability"
              value={newAvailability}
              onChange={(e) => setNewAvailability(e.target.value)}
              className="p-2 border rounded mb-4"
            />
            <button
              onClick={handleAddAvailability}
              className="bg-blue-600 text-white px-4 py-2 rounded mb-6"
            >
              Add Availability
            </button>

            {/* Therapist Availability List */}
            <ul>
              {therapistSchedule.map((availability, index) => (
                <li key={index} className="bg-white p-4 rounded shadow-md mb-2">
                  {availability}
                </li>
              ))}
            </ul>
          </div>
        )}

        {/* Payments & Reports */}
        {activeTab === 'payments' && (
          <div>
            <h2 className="text-2xl font-semibold mb-4">Payments & Reports</h2>

            {/* Payment Filters */}
            <div className="mb-4">
              <label className="mr-2">Payment Status:</label>
              <select
                value={paymentFilter}
                onChange={(e) => setPaymentFilter(e.target.value)}
                className="p-2 border rounded"
              >
                <option value="all">All</option>
                <option value="paid">Paid</option>
                <option value="unpaid">Unpaid</option>
                <option value="refunded">Refunded</option>
              </select>
            </div>

            {/* Payments Table */}
            <table className="table-auto w-full border-collapse">
              <thead>
                <tr className="border-b">
                  <th className="p-2">ID</th>
                  <th className="p-2">Amount</th>
                  <th className="p-2">Status</th>
                  <th className="p-2">Date</th>
                </tr>
              </thead>
              <tbody>
                {payments
                  .filter(
                    (payment) =>
                      paymentFilter === 'all' ||
                      payment.status === paymentFilter
                  )
                  .map((payment) => (
                    <tr key={payment.id}>
                      <td className="p-2">{payment.id}</td>
                      <td className="p-2">${payment.amount}</td>
                      <td className="p-2">{payment.status}</td>
                      <td className="p-2">{payment.date}</td>
                    </tr>
                  ))}
              </tbody>
            </table>

            {/* Report Chart */}
            <div className="mt-8">
              <h3 className="text-xl font-semibold">
                Bookings & Earnings Report
              </h3>
              <Line data={chartData} />
            </div>
          </div>
        )}
      </div>
    </div>
  )
}

export default AdminDashboard
