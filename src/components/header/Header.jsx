import { Link } from 'react-router-dom'

export default function Header() {
  return (
    <div>
      <nav className="flex items-center justify-between h-20 w-full fixed bg-orange-200 mb-20 top-0 left-0 z-50">
        <Link to={'/'}>
          <div className="ml-5 flex items-center justify-center">
            <img
              className="h-[10vh] w-30"
              src="/images/spa-logo-header.png"
              alt=""
            />
            <h1 className="text-green-900   font-bold text-xl sm:text-2xl md:text-3xl cursor-pointer tracking-wide -ml-7">
              LUHLUH's SPA
            </h1>
          </div>
        </Link>
        <ul className="flex list-none items-center space-x-6 text-gray-800 font-semibold">
          <Link to={'/'}>
            <li className="cursor-pointer list-none hover:text-green-500">
              Home
            </li>
          </Link>
          <Link to={'/servicepage'}>
            <li className="cursor-pointer hover:text-green-500">
              Service List
            </li>
          </Link>
          <Link to={'/booking'}>
            <li className="cursor-pointer hover:text-green-500">Booking</li>
          </Link>
          <Link to={'/userdashboard'}>
            <li className="cursor-pointer hover:text-green-500">User</li>
          </Link>
          <Link to={'/admindashboard'}>
            <li className="cursor-pointer hover:text-green-500">Admin</li>
          </Link>
        </ul>
        <div className="flex gap-2 mr-8">
          <Link to={'/userdashboard'}>
            <div className="cursor-pointer">Login</div>
          </Link>
          <Link to={'/userdashboard'}>
            <div className="cursor-pointer">Register</div>
          </Link>
        </div>
      </nav>
    </div>
  )
}
