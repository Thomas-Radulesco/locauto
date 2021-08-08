import { uploadedPhotosFolder, apiVehiclePhotosRoute } from './envConfig';

function init() {
    let vehicleSelect = document.querySelector('#order_admin_vehicleId');
    let vehicleImagePreview = document.querySelector('img[name=vehicle-picture]');
    let label = document.querySelector('label[for=vehicle-picture]');
    let imageName = '';

    if(vehicleSelect) {
      vehicleSelect.addEventListener('change', updateVehicleImagePreview);

      function updateVehicleImagePreview() {
        
        fetch(apiVehiclePhotosRoute + vehicleSelect.value)
        .then(response => response.json())
        .then(data => {
          imageName = data['vehiclePicture'] ? data['vehiclePicture'] : null;
          if(imageName) {
            vehicleImagePreview.src = uploadedPhotosFolder + '/' + imageName;
          }
          else {
            vehicleImagePreview.src = "https://via.placeholder.com/200x150.webp?text=www.locauto.fr";
          }
          label.innerText = data['vehicleName'] ? data['vehicleName'] : 'Véhicule sans nom' ;
        })
        .catch((error) => {
          console.error('Error:', error);
        });
      }
    }
}


window.addEventListener("DOMContentLoaded", () => {
    init();
  });