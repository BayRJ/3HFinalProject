import React, { useState } from 'react'

// Mock data for appointments and user information
const upcomingAppointments = [
  {
    id: 1,
    service: 'Massage',
    date: '2024-11-20',
    time: '10:00 AM',
    therapist: 'Sarah Johnson',
  },
  {
    id: 2,
    service: 'Facial',
    date: '2024-11-22',
    time: '2:00 PM',
    therapist: 'Emma White',
  },
]

const pastAppointments = [
  {
    id: 1,
    service: 'Pedicure',
    date: '2024-10-15',
    time: '1:00 PM',
    therapist: 'James Smith',
    review: '',
  },
  {
    id: 2,
    service: 'Massage',
    date: '2024-09-30',
    time: '11:00 AM',
    therapist: 'Sarah Johnson',
    review: 'Great experience!',
  },
]

const user = {
  name: 'John Doe',
  email: 'john.doe@example.com',
  phone: '123-456-7890',
}

const promotions = [
  {
    id: 1,
    title: '10% off your next service',
    description: 'Use code SAVE10 at checkout.',
  },
  {
    id: 2,
    title: 'Free upgrade to premium facial',
    description: 'Exclusive offer for loyal customers.',
  },
]

const UserDashboard = () => {
  const [selectedTab, setSelectedTab] = useState('appointments')
  const [editingProfile, setEditingProfile] = useState(false)
  const [userProfile, setUserProfile] = useState(user)
  const [newPassword, setNewPassword] = useState('')

  const handleTabChange = (tab) => setSelectedTab(tab)

  const handleCancelAppointment = (id) => {
    alert(`Appointment with ID: ${id} canceled.`)
  }

  const handleRescheduleAppointment = (id) => {
    alert(`Appointment with ID: ${id} rescheduled.`)
  }

  const handleReviewChange = (id, review) => {
    // Update review for past appointment
    const updatedAppointments = pastAppointments.map((appointment) =>
      appointment.id === id ? { ...appointment, review } : appointment
    )
    alert(`Review for appointment ID: ${id} updated.`)
  }

  const handleProfileUpdate = (e) => {
    e.preventDefault()
    setEditingProfile(false)
    alert('Profile updated successfully!')
  }

  const handlePasswordChange = (e) => {
    e.preventDefault()
    setNewPassword('')
    alert('Password updated successfully!')
  }

  return (
    <div className="w-full h-[110vh] bg-orange-100 p-1">
      <div className="container mx-auto p-6 bg-gray-100 mt-24 pt-10 w-[90vw] ">
        <h1 className="text-3xl font-semibold mb-8">User Dashboard</h1>

        {/* Tabs for navigation */}
        <div className="mb-6 flex space-x-6">
          <button
            onClick={() => handleTabChange('appointments')}
            className={`text-xl font-medium ${
              selectedTab === 'appointments' ? 'text-blue-600' : 'text-gray-700'
            }`}
          >
            Appointments
          </button>
          <button
            onClick={() => handleTabChange('settings')}
            className={`text-xl font-medium ${
              selectedTab === 'settings' ? 'text-blue-600' : 'text-gray-700'
            }`}
          >
            Account Settings
          </button>
          <button
            onClick={() => handleTabChange('promotions')}
            className={`text-xl font-medium ${
              selectedTab === 'promotions' ? 'text-blue-600' : 'text-gray-700'
            }`}
          >
            Promotions & Rewards
          </button>
        </div>

        {/* Content */}
        {selectedTab === 'appointments' && (
          <div>
            <h2 className="text-2xl font-semibold mb-4">
              Upcoming Appointments
            </h2>
            <div className="space-y-4">
              {upcomingAppointments.map((appointment) => (
                <div
                  key={appointment.id}
                  className="bg-white p-4 rounded-lg shadow-md flex justify-between"
                >
                  <div>
                    <h3 className="font-semibold  ">{appointment.service}</h3>
                    <p>
                      {appointment.date} at {appointment.time}
                    </p>
                    <p>Therapist: {appointment.therapist}</p>
                  </div>
                  <div className="flex space-x-4">
                    <button
                      onClick={() => handleCancelAppointment(appointment.id)}
                      className="bg-red-500 text-white px-4 py-2 rounded-lg"
                    >
                      Cancel
                    </button>
                    <button
                      onClick={() =>
                        handleRescheduleAppointment(appointment.id)
                      }
                      className="bg-yellow-500 text-white px-4 py-2 rounded-lg"
                    >
                      Reschedule
                    </button>
                  </div>
                </div>
              ))}
            </div>

            <h2 className="text-2xl font-semibold mt-8 mb-4">
              Past Appointments
            </h2>
            <div className="space-y-4">
              {pastAppointments.map((appointment) => (
                <div
                  key={appointment.id}
                  className="bg-white p-4 rounded-lg shadow-md flex justify-between"
                >
                  <div>
                    <h3 className="font-semibold">{appointment.service}</h3>
                    <p>
                      {appointment.date} at {appointment.time}
                    </p>
                    <p>Therapist: {appointment.therapist}</p>
                  </div>
                  <div>
                    {appointment.review ? (
                      <p>
                        <strong>Review:</strong> {appointment.review}
                      </p>
                    ) : (
                      <textarea
                        placeholder="Leave a review"
                        className="mt-2 p-2 border rounded-lg w-64"
                        value={appointment.review}
                        onChange={(e) =>
                          handleReviewChange(appointment.id, e.target.value)
                        }
                      />
                    )}
                  </div>
                </div>
              ))}
            </div>
          </div>
        )}

        {selectedTab === 'settings' && (
          <div>
            <h2 className="text-2xl font-semibold mb-4">Account Settings</h2>

            {editingProfile ? (
              <form onSubmit={handleProfileUpdate} className="space-y-4">
                <div>
                  <label className="block text-lg">Name</label>
                  <input
                    type="text"
                    className="w-full p-2 border rounded-lg"
                    defaultValue={userProfile.name}
                    onChange={(e) =>
                      setUserProfile({ ...userProfile, name: e.target.value })
                    }
                  />
                </div>
                <div>
                  <label className="block text-lg">Email</label>
                  <input
                    type="email"
                    className="w-full p-2 border rounded-lg"
                    defaultValue={userProfile.email}
                    onChange={(e) =>
                      setUserProfile({ ...userProfile, email: e.target.value })
                    }
                  />
                </div>
                <div>
                  <label className="block text-lg">Phone Number</label>
                  <input
                    type="tel"
                    className="w-full p-2 border rounded-lg"
                    defaultValue={userProfile.phone}
                    onChange={(e) =>
                      setUserProfile({ ...userProfile, phone: e.target.value })
                    }
                  />
                </div>
                <button
                  type="submit"
                  className="bg-blue-600 text-white px-4 py-2 rounded-lg"
                >
                  Update Profile
                </button>
              </form>
            ) : (
              <div>
                <p>
                  <strong>Name:</strong> {userProfile.name}
                </p>
                <p>
                  <strong>Email:</strong> {userProfile.email}
                </p>
                <p>
                  <strong>Phone:</strong> {userProfile.phone}
                </p>
                <button
                  onClick={() => setEditingProfile(true)}
                  className="mt-4 bg-yellow-500 text-white px-4 py-2 rounded-lg"
                >
                  Edit Profile
                </button>
              </div>
            )}

            <h2 className="text-2xl font-semibold mt-8 mb-4">
              Change Password
            </h2>
            <form onSubmit={handlePasswordChange} className="space-y-4">
              <div>
                <label className="block text-lg">New Password</label>
                <input
                  type="password"
                  className="w-full p-2 border rounded-lg"
                  value={newPassword}
                  onChange={(e) => setNewPassword(e.target.value)}
                />
              </div>
              <button
                type="submit"
                className="bg-blue-600 text-white px-4 py-2 rounded-lg"
              >
                Change Password
              </button>
            </form>
          </div>
        )}

        {selectedTab === 'promotions' && (
          <div>
            <h2 className="text-2xl font-semibold mb-4">
              Promotions & Rewards
            </h2>
            <div className="space-y-4">
              {promotions.map((promotion) => (
                <div
                  key={promotion.id}
                  className="bg-white p-4 rounded-lg shadow-md"
                >
                  <h3 className="font-semibold">{promotion.title}</h3>
                  <p>{promotion.description}</p>
                </div>
              ))}
            </div>
          </div>
        )}
      </div>
    </div>
  )
}

export default UserDashboard
