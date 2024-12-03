import React, { useState } from 'react'
const services = [
  {
    id: 1,
    name: 'Service One',
    price: 50,
    duration: 30,
    popularity: 4.5,
    description: 'This is a great service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 2,
    name: 'Service Two',
    price: 100,
    duration: 60,
    popularity: 4.7,
    description: 'This is an amazing service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 3,
    name: 'Service Three',
    price: 75,
    duration: 45,
    popularity: 4.2,
    description: 'This is a wonderful service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 4,
    name: 'Service Four',
    price: 85,
    duration: 50,
    popularity: 4.8,
    description: 'This is a premium service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 5,
    name: 'Service Five',
    price: 40,
    duration: 25,
    popularity: 4.3,
    description: 'This is a budget-friendly service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 6,
    name: 'Service Six',
    price: 60,
    duration: 35,
    popularity: 4.6,
    description: 'This is a highly-rated service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 7,
    name: 'Service Seven',
    price: 120,
    duration: 70,
    popularity: 4.9,
    description: 'This is an exceptional service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 8,
    name: 'Service Eight',
    price: 95,
    duration: 55,
    popularity: 4.4,
    description: 'This is a reliable service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 9,
    name: 'Service Nine',
    price: 110,
    duration: 65,
    popularity: 4.7,
    description: 'This is a top-notch service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    id: 10,
    name: 'Service Ten',
    price: 70,
    duration: 40,
    popularity: 4.5,
    description: 'This is a highly recommended service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
]

export default function ServiceList() {
  const [selectedPriceRange, setSelectedPriceRange] = useState('')
  const [selectedDuration, setSelectedDuration] = useState('')
  const [sortOption, setSortOption] = useState('popularity')

  const handleSortChange = (e) => {
    setSortOption(e.target.value)
  }

  const filteredServices = services
    .filter((service) => {
      if (selectedPriceRange === '') return true
      const [minPrice, maxPrice] = selectedPriceRange.split('-').map(Number)
      return service.price >= minPrice && service.price <= maxPrice
    })
    .filter((service) => {
      if (selectedDuration === '') return true
      return service.duration <= parseInt(selectedDuration)
    })

  const sortedServices = [...filteredServices].sort((a, b) => {
    if (sortOption === 'popularity') {
      return b.popularity - a.popularity
    } else if (sortOption === 'price') {
      return a.price - b.price
    } else if (sortOption === 'duration') {
      return a.duration - b.duration
    }
    return 0
  })

  return (
    <div className="flex space-x-8 p-8">
      {/* Filters Sidebar */}
      <div className="w-1/4 bg-gray-100 p-4 rounded-lg">
        <h2 className="text-xl font-bold mb-4">Filters</h2>

        {/* Price Range Filter */}
        <div className="mb-4">
          <label className="block font-medium">Price Range</label>
          <select
            value={selectedPriceRange}
            onChange={(e) => setSelectedPriceRange(e.target.value)}
            className="w-full mt-1 p-2 border border-gray-300 rounded-lg"
          >
            <option value="">All Prices</option>
            <option value="0-50">$0 - $50</option>
            <option value="51-100">$51 - $100</option>
            <option value="101-150">$101 - $150</option>
          </select>
        </div>

        {/* Duration Filter */}
        <div className="mb-4">
          <label className="block font-medium">Max Duration (minutes)</label>
          <select
            value={selectedDuration}
            onChange={(e) => setSelectedDuration(e.target.value)}
            className="w-full mt-1 p-2 border border-gray-300 rounded-lg"
          >
            <option value="">Any Duration</option>
            <option value="30">30 minutes</option>
            <option value="60">60 minutes</option>
            <option value="90">90 minutes</option>
          </select>
        </div>
      </div>

      {/* Service List Section */}
      <div className="w-3/4">
        {/* Sorting Dropdown */}
        <div className="mb-4 flex justify-between items-center">
          <h2 className="text-xl font-bold">Available Services</h2>
          <div className="flex space-x-4">
            <label>Sort by:</label>
            <select
              value={sortOption}
              onChange={handleSortChange}
              className="p-2 border border-gray-300 rounded-lg"
            >
              <option value="popularity">Popularity</option>
              <option value="price">Price</option>
              <option value="duration">Duration</option>
            </select>
          </div>
        </div>

        {/* Service Cards */}
        <div className="grid grid-cols-3 gap-6">
          {sortedServices.map((service) => (
            <div key={service.id} className="bg-white p-4 rounded-lg shadow-md">
              <img
                src={service.imageUrl}
                alt={service.name}
                className="w-full h-40 object-cover rounded-lg mb-4"
              />
              <h3 className="text-lg font-semibold">{service.name}</h3>
              <p className="text-gray-600 text-sm mb-2">${service.price}</p>
              <p className="text-gray-500 text-sm mb-2">
                {service.description}
              </p>
              <p className="text-gray-500 text-sm mb-4">
                Duration: {service.duration} minutes
              </p>
              <a
                href={`/booking/${service.id}`}
                className="bg-green-500 text-white text-center px-4 py-2 rounded-lg w-full block text-sm"
              >
                Book Now
              </a>
            </div>
          ))}
        </div>
      </div>
    </div>
  )
}
