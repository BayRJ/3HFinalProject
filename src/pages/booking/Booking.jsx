import React, { useState } from 'react'
import DatePicker from 'react-datepicker'
import 'react-datepicker/dist/react-datepicker.css'
import timeSlots from '../../timeSlots'
// Mock data for services and therapists
const services = [
  { id: 1, name: 'Massage', price: 80 },
  { id: 2, name: 'Facial', price: 100 },
  { id: 3, name: 'Pedicure', price: 50 },
]

const therapists = [
  { id: 1, name: 'Sarah Johnson' },
  { id: 2, name: 'James Smith' },
  { id: 3, name: 'Emma White' },
]

const BookingPage = () => {
  const [step, setStep] = useState(1) // To manage the current step in the booking process
  const [selectedService, setSelectedService] = useState(null)
  const [selectedTherapist, setSelectedTherapist] = useState(null)
  const [selectedDate, setSelectedDate] = useState(null)
  const [availableTimeSlots, setAvailableTimeSlots] = useState([])
  const [selectedTime, setSelectedTime] = useState('')
  const [paymentMethod, setPaymentMethod] = useState('')
  const [promoCode, setPromoCode] = useState('')
  const [appointment, setAppointment] = useState({})

  const handleDateChange = (date) => {
    setSelectedDate(date)
    const formattedDate =
      date.getFullYear() +
      '-' +
      String(date.getMonth() + 1).padStart(2, '0') +
      '-' +
      String(date.getDate()).padStart(2, '0')
    setAvailableTimeSlots(timeSlots[formattedDate] || [])
  }

  const handleSubmit = () => {
    setAppointment({
      service: setSelectedService,
      therapist: setSelectedTherapist,
      date: selectedDate,
      time: selectedTime,
      isCompleted: false,
      adminStatus: 'pending',
    })
  }

  const renderStep1 = () => (
    <div>
      <h2 className="text-2xl font-semibold mb-4">
        Step 1: Select Service and Therapist
      </h2>
      <div className="mb-4">
        <label className="block text-lg font-medium">Select Service</label>
        <select
          value={selectedService}
          onChange={(e) => setSelectedService(e.target.value)}
          className="w-full p-2 border border-gray-300 rounded-lg"
        >
          <option value="">--Choose a Service--</option>
          {services.map((service) => (
            <option key={service.id} value={service.id}>
              {service.name} - ${service.price}
            </option>
          ))}
        </select>
      </div>

      <div className="mt-6">
        <label className="block text-lg font-medium">Select Therapist</label>
        <select
          value={selectedTherapist}
          onChange={(e) => setSelectedTherapist(e.target.value)}
          className="w-full p-2 border border-gray-300 rounded-lg"
        >
          <option value="">--Choose a Therapist--</option>
          {therapists.map((therapist) => (
            <option key={therapist.id} value={therapist.id}>
              {therapist.name}
            </option>
          ))}
        </select>
      </div>
      {selectedService && (
        <div className="mt-4">
          <h3 className="text-lg font-semibold">Service Summary</h3>
          <p>{services.find((s) => s.id === parseInt(selectedService)).name}</p>
          <p>
            Price: $
            {services.find((s) => s.id === parseInt(selectedService)).price}
          </p>
        </div>
      )}
      <div className="mt-6 flex justify-end">
        <button
          onClick={() => setStep(step + 1)}
          className="bg-gray-200 p-3 rounded-lg"
        >
          Next Step
        </button>
      </div>
    </div>
  )

  const renderStep2 = () => (
    <div>
      <h2 className="text-2xl font-semibold mb-4">
        Step 2: Choose Date and Time
      </h2>
      <div className="mb-4">
        <label className="block text-lg font-medium">Select Date</label>
        <DatePicker
          selected={selectedDate}
          onChange={handleDateChange}
          inline
        />
      </div>

      {selectedDate && (
        <div>
          <label className="block text-lg font-medium mb-2">
            Available Time Slots
          </label>
          <div className="space-y-2">
            {availableTimeSlots.length > 0 ? (
              availableTimeSlots.map((time) => (
                <div key={time} className="flex items-center space-x-2">
                  <input
                    type="radio"
                    name="time"
                    value={time}
                    onChange={(e) => setSelectedTime(e.target.value)}
                    className="h-4 w-4"
                  />
                  <span>{time}</span>
                </div>
              ))
            ) : (
              <p>No available time slots for this date.</p>
            )}
          </div>
        </div>
      )}

      <div className="mt-6 flex justify-between">
        <button
          onClick={() => setStep(step - 1)}
          className="bg-gray-200 p-3 rounded-lg"
        >
          Previous Step
        </button>
        <button
          onClick={() => setStep(step + 1)}
          className="bg-gray-200 p-3 rounded-lg"
        >
          Next Step
        </button>
      </div>
    </div>
  )

  const renderStep3 = () => (
    <div>
      <h2 className="text-2xl font-semibold mb-4">
        Step 3: Confirmation and Payment
      </h2>
      <div className="mb-4">
        <h3 className="text-lg font-semibold">Appointment Summary</h3>
        <p>
          Service:{' '}
          {services.find((s) => s.id === parseInt(selectedService)).name}
        </p>
        <p>
          Therapist:{' '}
          {therapists.find((t) => t.id === parseInt(selectedTherapist)).name}
        </p>
        <p>Date: {selectedDate ? selectedDate.toLocaleDateString() : 'N/A'}</p>
        <p>Time: {selectedTime}</p>
        <p>
          Price: $
          {services.find((s) => s.id === parseInt(selectedService)).price}
        </p>
      </div>

      <div className="mb-4">
        <label className="block text-lg font-medium">Payment Method</label>
        <select
          value={paymentMethod}
          onChange={(e) => setPaymentMethod(e.target.value)}
          className="w-full p-2 border border-gray-300 rounded-lg"
        >
          <option value="">--Choose a Payment Method--</option>
          <option value="credit-card">Credit Card</option>
          <option value="paypal">PayPal</option>
          <option value="cash">Cash</option>
        </select>
      </div>

      <div className="mb-4">
        <label className="block text-lg font-medium">Promo Code</label>
        <input
          type="text"
          value={promoCode}
          onChange={(e) => setPromoCode(e.target.value)}
          className="w-full p-2 border border-gray-300 rounded-lg"
          placeholder="Enter promo code"
        />
      </div>

      <div className="mt-6 flex justify-between">
        <button
          onClick={() => setStep(step - 1)}
          className="bg-gray-200 p-3 rounded-lg"
        >
          Previous Step
        </button>
        <button className="bg-gray-200 p-3 rounded-lg" onClick={handleSubmit}>
          Confirm Appointment
        </button>
      </div>
    </div>
  )

  return (
    <div className="w-full h-[100vh] bg-orange-100 p-1">
      <div className="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-36 ">
        {step === 1 && renderStep1()}
        {step === 2 && renderStep2()}
        {step === 3 && renderStep3()}
      </div>
    </div>
  )
}

export default BookingPage
