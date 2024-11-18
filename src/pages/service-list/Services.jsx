import React, { useContext, useState } from 'react'
import { GlobalContext } from '../../context/GlobalState'
import ServiceItem from '../../components/service-item/ServiceItem'

const ServicePage = () => {
  const [selectedPriceRange, setSelectedPriceRange] = useState('')
  const [selectedDuration, setSelectedDuration] = useState('')
  const [sortOption, setSortOption] = useState('popularity')
  const { serviceList } = useContext(GlobalContext)

  const handleSortChange = (e) => {
    setSortOption(e.target.value)
  }

  const filteredServices = serviceList
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
    <div className="flex space-x-8 p-8 pt-24">
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
            <option value="0-50">Pesos 0 - 50</option>
            <option value="51-100">Pesos 51 - 100</option>
            <option value="101-150">Pesos 101 - 150</option>
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
            <ServiceItem item={service} />
          ))}
        </div>
      </div>
    </div>
  )
}

export default ServicePage
