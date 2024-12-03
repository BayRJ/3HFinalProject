import React from 'react';
import { Route, Routes } from 'react-router-dom';
import Header from './components/header/Header';
import Home from './pages/home/Home';
import ServicePage from './pages/service-list/Services';
import UserDashboard from './pages/user/User';
import BookingPage from './pages/booking/Booking';
import AdminDashboard from './pages/admin/AdminDashboard';
import BookingList from './components/BookingList';
import ServiceCategoryList from './components/ServiceCategoryList';

function App() {
  return (
    <div className="bg-orange-100">
      <Header />
      <Routes>
        <Route exact path="/" element={<Home />} />
        <Route path="/servicepage" element={<ServicePage />} />
        <Route exact path="/booking" element={<BookingPage />} />
        <Route path="/userdashboard" element={<UserDashboard />} />
        <Route exact path="/admindashboard" element={<AdminDashboard />} />
        <Route path="/bookings" element={<BookingList />} />
        <Route path="/service-categories" element={<ServiceCategoryList />} />
      </Routes>
    </div>
  );
}

export default App;