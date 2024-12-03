import ServiceItem from '../../components/service-item/ServiceItem'
import { services } from '../../services'
import Testimonial from './Testimonial'

export default function Home() {
  return (
    <div className=" font-sans bg-orange-100">
      <div className="h-full w-full overflow-x-hidden pt-20">
        <div className="background-johny flex flex-col justify-center items-center ">
          <img src="/images/logo-spa-hero.png" alt="" className="opacity-50" />
          <div>
            <h2 className="text-5xl font-bold text-white ">
              Pamper yourself to perfection
            </h2>
            <h2 className="text-3xl font-bold  text-white text-center">
              Experience Johny at its Finest
            </h2>
          </div>
          <div className="flex gap-4 my-2 mt-6">
            <button className="bg-green-950 text-white border-2 rounded-lg font-bold p-8  border-none text-2xl hover:bg-white hover:text-green-500">
              Book Now
            </button>
            <button className="bg-green-950 text-white border-2 rounded-lg font-bold p-8  border-none text-2xl hover:bg-white hover:text-green-500">
              View Services
            </button>
          </div>
        </div>
      </div>
      <div className="h-2 w-full bg-black"></div>
      <div className="h-full w-full mb-20">
        <div className="w-full h-full">
          <h2 className="text-green-900 text-center text-4xl font-bold">
            Services Offered
          </h2>
          <div className="py-8 container mx-auto flex flex-wrap justify-center gap-10">
            {services && services.length > 0
              ? services.map((serviceItem) => {
                  return <ServiceItem item={serviceItem} />
                })
              : null}
          </div>
        </div>
      </div>
      <div className="h-2 w-full bg-black"></div>
      <div className="w-full h-full mb-20">
        <div className="w-full h-full">
          <h2 className="-mb-24 text-center text-green-900 font-bold">
            Testimonials
          </h2>
          <Testimonial />
        </div>
      </div>
      <div className="h-2 w-full bg-black"></div>
      <div className="w-full h-[50vh] flex flex-col justify-center items-center gap-6">
        <h2>Don't Wait Schedule Your first session now!</h2>
        <button className="bg-green-950 text-white border-2 rounded-lg font-bold p-8  border-none text-2xl hover:bg-green-300 hover:text-green-900">
          Book Now
        </button>
      </div>
      <div className="h-2 w-full bg-black"></div>
      <div className="w-full h-[1vh]"></div>
      <p className="text-xl text-center mb-2">
        © 2024 LuhLuh Spa. The best you deserved all time.
      </p>
    </div>
  )
}
