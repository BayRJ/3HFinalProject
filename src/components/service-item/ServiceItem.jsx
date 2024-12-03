import { Link } from 'react-router-dom'

export default function ServiceItem({ item }) {
  return (
    <div className="flex flex-col w-80 overflow-hidden p-5 bg-white/75 shadow-xl gap-5 border-2 rounded-2xl border-white ">
      <div className="h-40 flex justify-center overflow-hidden items-center rounded-xl">
        <img
          src="/images/johny-sins.jpg"
          alt="recipe item"
          className="block w-full object-cover"
        />
      </div>
      <div className="text-wrap break-words w-full">
        <span className="text-sm text-green-700 font-medium">
          {item?.serviceName}
        </span>
        <h3 className="font-bold text-sm text-black ">{item?.description}</h3>
        <h3 className="font-bold text-2xl truncate text-black">
          {item?.price} Pesos
        </h3>
        <h3 className="font-bold text-sm truncate text-black">
          {item?.duration} minutes
        </h3>
        <div className="w-full mt-auto">
          <Link
            to={`/recipe-item/${item?.serviceId}`}
            className="text-sm p-3 mt-5 px-8 rounded-lg uppercase font-medium tracking-wider inline-block shadow-md bg-green-900 text-white hover:bg-green-300 hover:text-green-900"
          >
            Book Now
          </Link>
        </div>
      </div>
    </div>
  )
}
