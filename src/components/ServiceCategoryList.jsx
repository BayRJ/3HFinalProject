import React, { useState, useEffect } from 'react';

const ServiceCategoryList = () => {
  const [serviceCategories, setServiceCategories] = useState([]);

  useEffect(() => {
    fetch('http://localhost/api/read-service-categories.php')
      .then(response => response.json())
      .then(data => setServiceCategories(data))
      .catch(error => console.error('Error fetching service categories:', error));
  }, []);

  return (
    <div>
      <h2>Service Categories</h2>
      <ul>
        {serviceCategories.map(sc => (
          <li key={`${sc.service_id}-${sc.category_id}`}>
            Service ID: {sc.service_id}, Category ID: {sc.category_id}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default ServiceCategoryList;