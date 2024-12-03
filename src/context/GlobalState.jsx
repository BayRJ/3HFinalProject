import { createContext, useState } from 'react'

export const GlobalContext = createContext(null)

export const services = [
  {
    serviceId: 1,
    serviceName: 'Service One',
    price: 50,
    duration: 30,
    popularity: 4.5,
    description: 'This is a great service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 2,
    serviceName: 'Service Two',
    price: 100,
    duration: 60,
    popularity: 4.7,
    description: 'This is an amazing service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 3,
    serviceName: 'Service Three',
    price: 75,
    duration: 45,
    popularity: 4.2,
    description: 'This is a wonderful service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 4,
    serviceName: 'Service Four',
    price: 120,
    duration: 90,
    popularity: 4.9,
    description: 'This is a premium service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 5,
    serviceName: 'Service Five',
    price: 60,
    duration: 40,
    popularity: 4.3,
    description: 'This service offers great value.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 6,
    serviceName: 'Service Six',
    price: 80,
    duration: 50,
    popularity: 4.6,
    description: 'High-quality and reliable.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 7,
    serviceName: 'Service Seven',
    price: 95,
    duration: 55,
    popularity: 4.4,
    description: 'Highly recommended.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 8,
    serviceName: 'Service Eight',
    price: 110,
    duration: 70,
    popularity: 4.8,
    description: 'An excellent option for most users.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 9,
    serviceName: 'Service Nine',
    price: 65,
    duration: 35,
    popularity: 4.1,
    description: 'Affordable yet effective service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 10,
    serviceName: 'Service Ten',
    price: 150,
    duration: 120,
    popularity: 5.0,
    description: 'Top-tier service.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 11,
    serviceName: 'Service Eleven',
    price: 45,
    duration: 25,
    popularity: 3.9,
    description: 'A quick solution for smaller needs.',
    imageUrl: 'https://via.placeholder.com/150',
  },
  {
    serviceId: 12,
    serviceName: 'Service Twelve',
    price: 130,
    duration: 80,
    popularity: 4.7,
    description: 'The best service for premium users.',
    imageUrl: 'https://via.placeholder.com/150',
  },
]

export default function GlobalState({ children }) {
  const [serviceList, setServiceList] = useState(services)
  const [bookingList, setBookingList] = useState([])

  return (
    <GlobalContext.Provider
      value={{ serviceList, setServiceList, bookingList, setBookingList }}
    >
      {children}
    </GlobalContext.Provider>
  )
}
