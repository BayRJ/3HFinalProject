import { useState } from 'react'
import { testimonials } from '../../testimonials'
import { FaQuoteRight } from 'react-icons/fa'
import { FiChevronLeft, FiChevronRight } from 'react-icons/fi'

const Testimonial = () => {
  const [people, setPeople] = useState(testimonials)
  const [currentPerson, setCurrentPerson] = useState(0)

  const prevSlide = () => {
    setCurrentPerson((oldPerson) => {
      const result = (oldPerson - 1 + people.length) % people.length
      return result
    })
  }
  const nextSlide = () => {
    setCurrentPerson((oldPerson) => {
      const result = (oldPerson + 1) % people.length
      return result
    })
  }

  return (
    <section className="slider-container">
      {people.map((person, personIndex) => {
        const { id, image, name, rating, comment } = person
        return (
          <article
            className="slide"
            style={{
              transform: `translateX(${100 * (personIndex - currentPerson)}%)`,
              opacity: personIndex === currentPerson ? 1 : 0,
              visibility: personIndex === currentPerson ? 'visible' : 'hidden',
            }}
            key={id}
          >
            <img src={image} alt={name} className="person-img mx-auto" />
            <h5 className="name font-bold">{name}</h5>
            <p className="title font-bold">{rating}</p>
            <p className="text text-2xl">{comment}</p>
            <FaQuoteRight className="icon mx-auto" size={50} />
          </article>
        )
      })}
      <button type="button" className="prev" onClick={prevSlide}>
        <FiChevronLeft />
      </button>
      <button type="button" className="next" onClick={nextSlide}>
        <FiChevronRight />
      </button>
    </section>
  )
}
export default Testimonial
